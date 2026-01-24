<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageSubscription extends Model
{
    protected $fillable = [
        'user_id', 'package_id', 'amount_paid', 'jobs_remaining',
        'featured_jobs_remaining', 'cv_access_remaining', 'status',
        'starts_at', 'expires_at',
    ];

    protected $casts = [
        'amount_paid' => 'decimal:2',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function package(): BelongsTo { return $this->belongsTo(Package::class); }

    public function scopeActive($q) { return $q->where('status', 'active')->where('expires_at', '>', now()); }

    public function isActive(): bool { return $this->status === 'active' && $this->expires_at > now(); }
    public function hasJobCredits(): bool { return $this->jobs_remaining > 0; }
    public function hasCvCredits(): bool { return $this->cv_access_remaining > 0; }

    public function useJobCredit(): bool
    {
        if ($this->jobs_remaining <= 0) return false;
        $this->decrement('jobs_remaining');
        return true;
    }

    public function useCvCredit(): bool
    {
        if ($this->cv_access_remaining <= 0) return false;
        $this->decrement('cv_access_remaining');
        return true;
    }
}
