<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Payment extends Model
{
    protected $fillable = [
        'uuid', 'user_id', 'package_id', 'subscription_id',
        'stripe_payment_intent_id', 'stripe_customer_id',
        'amount', 'currency', 'status', 'payment_method',
        'metadata', 'failure_reason', 'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
        'paid_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($p) => $p->uuid = $p->uuid ?? Str::uuid());
    }

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function package(): BelongsTo { return $this->belongsTo(Package::class); }
    public function subscription(): BelongsTo { return $this->belongsTo(PackageSubscription::class); }

    public function scopeCompleted($q) { return $q->where('status', 'completed'); }
    public function scopePending($q) { return $q->where('status', 'pending'); }

    public function markCompleted(): void
    {
        $this->update(['status' => 'completed', 'paid_at' => now()]);
    }

    public function markFailed(string $reason): void
    {
        $this->update(['status' => 'failed', 'failure_reason' => $reason]);
    }
}
