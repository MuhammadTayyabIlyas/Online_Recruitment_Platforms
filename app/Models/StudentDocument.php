<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentDocument extends Model
{
    protected $fillable = [
        'user_id',
        'document_type',
        'document_name',
        'file_path',
        'original_filename',
        'file_size',
        'mime_type',
        'is_verified',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    protected $appends = ['file_size_formatted'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFileSizeFormattedAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' bytes';
    }

    public static function getDocumentTypes(): array
    {
        return [
            'transcript' => 'Academic Transcript',
            'diploma' => 'Diploma/Degree Certificate',
            'passport' => 'Passport Copy',
            'recommendation' => 'Letter of Recommendation',
            'sop' => 'Statement of Purpose',
            'cv' => 'Curriculum Vitae (CV)',
            'language_test' => 'Language Test Results',
            'financial' => 'Financial Documents',
            'portfolio' => 'Portfolio',
            'other' => 'Other',
        ];
    }
}
