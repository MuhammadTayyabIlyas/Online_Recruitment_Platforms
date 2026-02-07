<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuthorizedPartner extends Model
{
    protected $fillable = [
        'user_id',
        'reference_number',
        'business_name',
        'tax_id',
        'address_line1',
        'address_line2',
        'city',
        'postal_code',
        'country',
        'phone',
        'email',
        'authorized_countries',
        'status',
        'approved_at',
        'expires_at',
        'admin_notes',
        'certificate_path',
    ];

    protected function casts(): array
    {
        return [
            'authorized_countries' => 'array',
            'approved_at' => 'date',
            'expires_at' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && $this->expires_at && $this->expires_at->gt(now());
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->lte(now());
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending_profile' => 'Pending Profile',
            'pending_review' => 'Pending Review',
            'active' => $this->isExpired() ? 'Expired' : 'Active',
            'suspended' => 'Suspended',
            'revoked' => 'Revoked',
            default => ucfirst($this->status),
        };
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')->where('expires_at', '>', now());
    }

    public static function generateReferenceNumber(): string
    {
        $year = now()->year;
        $lastPartner = static::whereYear('created_at', $year)->orderByDesc('id')->first();

        if ($lastPartner && preg_match('/AP-\d{4}-(\d{5})/', $lastPartner->reference_number, $matches)) {
            $nextNumber = (int) $matches[1] + 1;
        } else {
            $nextNumber = 1;
        }

        return sprintf('AP-%d-%05d', $year, $nextNumber);
    }

    public function getAuthorizedCountryLabelsAttribute(): array
    {
        $labels = [
            'greece' => 'Greece',
            'portugal' => 'Portugal',
            'uk' => 'United Kingdom',
        ];

        return collect($this->authorized_countries ?? [])
            ->map(fn($country) => $labels[$country] ?? ucfirst($country))
            ->toArray();
    }
}
