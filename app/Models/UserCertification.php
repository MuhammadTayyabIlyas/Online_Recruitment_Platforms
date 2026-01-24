<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $issuing_organization
 * @property \Carbon\Carbon $issue_date
 * @property \Carbon\Carbon|null $expiry_date
 * @property string|null $credential_id
 * @property string|null $credential_url
 * @property-read User $user
 */
class UserCertification extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'issuing_organization',
        'issue_date',
        'expiry_date',
        'credential_id',
        'credential_url',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
    ];

    /**
     * Get the user that owns the certification.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the certification is expired.
     */
    public function isExpired(): bool
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    /**
     * Check if the certification is valid (not expired).
     */
    public function isValid(): bool
    {
        return !$this->expiry_date || $this->expiry_date->isFuture();
    }

    /**
     * Validate and set the credential URL.
     */
    public function setCredentialUrlAttribute(?string $value): void
    {
        $this->attributes['credential_url'] = $value ? filter_var($value, FILTER_SANITIZE_URL) : null;
    }
}
