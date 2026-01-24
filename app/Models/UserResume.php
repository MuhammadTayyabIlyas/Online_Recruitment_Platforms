<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $file_path
 * @property string $file_name
 * @property int $file_size
 * @property string $mime_type
 * @property bool $is_primary
 * @property int $download_count
 * @property-read User $user
 */
class UserResume extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Allowed MIME types for resumes.
     */
    public const ALLOWED_MIME_TYPES = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'file_path',
        'file_name',
        'file_size',
        'mime_type',
        'is_primary',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'file_size' => 'integer',
        'is_primary' => 'boolean',
        'download_count' => 'integer',
    ];

    /**
     * Get the user that owns the resume.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the file size formatted for display.
     */
    public function getFormattedFileSizeAttribute(): string
    {
        $bytes = $this->file_size;

        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }

        return $bytes . ' bytes';
    }

    /**
     * Increment the download count atomically.
     */
    public function incrementDownloadCount(): void
    {
        DB::table('user_resumes')
            ->where('id', $this->id)
            ->increment('download_count');

        $this->refresh();
    }

    /**
     * Set this resume as the primary resume.
     */
    public function setAsPrimary(): void
    {
        // Remove primary status from other resumes
        self::where('user_id', $this->user_id)
            ->where('id', '!=', $this->id)
            ->update(['is_primary' => false]);

        // Set this resume as primary
        $this->update(['is_primary' => true]);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // When creating a new resume, if it's marked as primary, unset others
        static::creating(function ($resume) {
            if ($resume->is_primary) {
                self::where('user_id', $resume->user_id)
                    ->update(['is_primary' => false]);
            }
        });

        // When updating a resume to primary, unset others
        static::updating(function ($resume) {
            if ($resume->isDirty('is_primary') && $resume->is_primary) {
                self::where('user_id', $resume->user_id)
                    ->where('id', '!=', $resume->id)
                    ->update(['is_primary' => false]);
            }
        });
    }
}
