<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Package extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'price', 'duration_days', 'features',
        'job_posts_limit', 'featured_jobs_limit', 'cv_access_limit',
        'has_priority_support', 'is_active', 'is_featured', 'sort_order',
    ];

    protected $casts = [
        'features' => 'array',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'has_priority_support' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($p) => $p->slug = $p->slug ?? Str::slug($p->name));
    }

    public function subscriptions(): HasMany { return $this->hasMany(PackageSubscription::class); }

    public function scopeActive($q) { return $q->where('is_active', true); }
    public function scopeOrdered($q) { return $q->orderBy('sort_order'); }
}
