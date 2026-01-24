<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property string $skill_name
 * @property string $proficiency_level
 * @property int $years_of_experience
 * @property-read User $user
 */
class UserSkill extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Proficiency level constants.
     */
    public const LEVEL_BEGINNER = 'beginner';
    public const LEVEL_INTERMEDIATE = 'intermediate';
    public const LEVEL_ADVANCED = 'advanced';
    public const LEVEL_EXPERT = 'expert';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'skill_name',
        'proficiency_level',
        'years_of_experience',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'years_of_experience' => 'integer',
    ];

    /**
     * Get the user that owns the skill.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Normalize skill name to lowercase before saving.
     */
    public function setSkillNameAttribute(string $value): void
    {
        $this->attributes['skill_name'] = strtolower(trim($value));
    }

    /**
     * Get skill name with proper capitalization.
     */
    public function getFormattedSkillNameAttribute(): string
    {
        return ucwords($this->skill_name);
    }
}
