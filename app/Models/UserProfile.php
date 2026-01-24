<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property string|null $headline
 * @property string|null $bio
 * @property string|null $location
 * @property string|null $website
 * @property string|null $linkedin_url
 * @property string|null $github_url
 * @property \Carbon\Carbon|null $date_of_birth
 * @property string|null $gender
 * @property string|null $nationality
 * @property-read User $user
 */
class UserProfile extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'headline',
        'bio',
        'location',
        'website',
        'linkedin_url',
        'github_url',
        'date_of_birth',
        'gender',
        'nationality',
        'is_searchable',
        'hide_contact_info',
        'current_job_title',
        'city',
        'country',
        'country_iso',
        'passport_number',
        'address',
        'postal_code',
        'province_state',
        'province_state_code',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user's age.
     */
    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth?->age;
    }

    /**
     * Validate and set the website URL.
     */
    public function setWebsiteAttribute(?string $value): void
    {
        $this->attributes['website'] = $value ? filter_var($value, FILTER_SANITIZE_URL) : null;
    }

    /**
     * Validate and set the LinkedIn URL.
     */
    public function setLinkedinUrlAttribute(?string $value): void
    {
        $this->attributes['linkedin_url'] = $value ? filter_var($value, FILTER_SANITIZE_URL) : null;
    }

    /**
     * Validate and set the GitHub URL.
     */
    public function setGithubUrlAttribute(?string $value): void
    {
        $this->attributes['github_url'] = $value ? filter_var($value, FILTER_SANITIZE_URL) : null;
    }
}
