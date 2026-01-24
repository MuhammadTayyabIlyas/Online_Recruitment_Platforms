<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property string $language
 * @property string $proficiency
 * @property-read User $user
 */
class UserLanguage extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Proficiency level constants.
     */
    public const PROFICIENCY_BASIC = 'basic';
    public const PROFICIENCY_CONVERSATIONAL = 'conversational';
    public const PROFICIENCY_FLUENT = 'fluent';
    public const PROFICIENCY_NATIVE = 'native';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'language',
        'proficiency',
    ];

    /**
     * Get the user that owns the language.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get formatted proficiency level.
     */
    public function getFormattedProficiencyAttribute(): string
    {
        return ucfirst($this->proficiency);
    }
}
