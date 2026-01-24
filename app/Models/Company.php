<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid', 'user_id', 'company_name', 'slug', 'logo', 'tagline', 'description',
        'industry_id', 'company_size', 'founded_year', 'website', 'email', 'phone',
        'address', 'city', 'state', 'country', 'postal_code', 'latitude', 'longitude',
        'social_links', 'is_verified', 'verification_documents', 'verified_at',
        'is_featured', 'is_active', 'is_cv_access_approved', 'jobs_count', 'views_count',
    ];

    protected $casts = [
        'social_links' => 'array',
        'is_verified' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'is_cv_access_approved' => 'boolean',
        'verified_at' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($company) {
            $company->uuid = $company->uuid ?? Str::uuid();
            $company->slug = $company->slug ?? Str::slug($company->company_name);
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(CompanyMedia::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
