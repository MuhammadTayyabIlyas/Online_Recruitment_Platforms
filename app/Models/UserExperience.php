<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property string $company_name
 * @property string $job_title
 * @property string|null $location
 * @property \Carbon\Carbon $start_date
 * @property \Carbon\Carbon|null $end_date
 * @property bool $is_current
 * @property string $employment_type
 * @property string|null $description
 * @property-read User $user
 */
class UserExperience extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_experience';

    /**
     * Employment type constants.
     */
    public const TYPE_FULL_TIME = 'full_time';
    public const TYPE_PART_TIME = 'part_time';
    public const TYPE_CONTRACT = 'contract';
    public const TYPE_FREELANCE = 'freelance';
    public const TYPE_INTERNSHIP = 'internship';
    public const TYPE_APPRENTICESHIP = 'apprenticeship';
    public const TYPE_TEMPORARY = 'temporary';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'company_name',
        'job_title',
        'location',
        'start_date',
        'end_date',
        'is_current',
        'employment_type',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];

    /**
     * Get the user that owns the experience record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the duration of employment in months.
     */
    public function getDurationInMonthsAttribute(): int
    {
        $endDate = $this->is_current ? now() : $this->end_date;
        return $this->start_date->diffInMonths($endDate);
    }

    /**
     * Get formatted employment type.
     */
    public function getFormattedEmploymentTypeAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->employment_type));
    }
}
