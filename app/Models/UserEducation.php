<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property string $institution
 * @property string $degree
 * @property string $field_of_study
 * @property int $start_date
 * @property int|null $end_date
 * @property bool $is_current
 * @property string|null $grade
 * @property string|null $description
 * @property-read User $user
 */
class UserEducation extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_education';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'institution',
        'degree',
        'field_of_study',
        'start_date',
        'end_date',
        'is_current',
        'grade',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'integer',
        'end_date' => 'integer',
        'is_current' => 'boolean',
    ];

    /**
     * Get the user that owns the education record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the duration of education.
     */
    public function getDurationAttribute(): string
    {
        $end = $this->is_current ? 'Present' : $this->end_date;
        return "{$this->start_date} - {$end}";
    }
}
