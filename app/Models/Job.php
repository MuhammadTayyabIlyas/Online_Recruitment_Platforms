<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'job_listings';

    protected $fillable = [
        'uuid', 'title', 'slug', 'company_id', 'user_id', 'category_id', 'industry_id',
        'job_type_id', 'employment_type_id', 'experience_level', 'education_level',
        'description', 'responsibilities', 'requirements', 'benefits',
        'min_salary', 'max_salary', 'salary_currency', 'salary_period', 'hide_salary',
        'location', 'city', 'state', 'country', 'is_remote',
        'apply_type', 'external_apply_url', 'apply_email',
        'status', 'views_count', 'applications_count',
        'is_featured', 'is_urgent', 'expires_at', 'published_at',
    ];

    protected $casts = [
        'benefits' => 'array',
        'is_remote' => 'boolean',
        'hide_salary' => 'boolean',
        'is_featured' => 'boolean',
        'is_urgent' => 'boolean',
        'expires_at' => 'datetime',
        'published_at' => 'datetime',
        'min_salary' => 'decimal:2',
        'max_salary' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($job) {
            $job->uuid = $job->uuid ?? Str::uuid();
            $job->slug = $job->slug ?? Str::slug($job->title) . '-' . Str::random(6);
        });
    }

    public function company(): BelongsTo { return $this->belongsTo(Company::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function category(): BelongsTo { return $this->belongsTo(Category::class); }
    public function industry(): BelongsTo { return $this->belongsTo(Industry::class); }
    public function jobType(): BelongsTo { return $this->belongsTo(JobType::class); }
    public function employmentType(): BelongsTo { return $this->belongsTo(EmploymentType::class); }
    public function skills(): BelongsToMany { return $this->belongsToMany(Skill::class, 'job_skills')->withPivot('is_required')->withTimestamps(); }
    public function questions(): HasMany { return $this->hasMany(JobQuestion::class)->orderBy('sort_order'); }
    public function applications(): HasMany { return $this->hasMany(JobApplication::class); }

    public function scopePublished($query) { return $query->where('status', 'published'); }
    public function scopeActive($query) { return $query->published()->where(fn($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>', now())); }
    public function scopeFeatured($query) { return $query->where('is_featured', true); }
    public function scopeUrgent($query) { return $query->where('is_urgent', true); }

    public function getSalaryRangeAttribute(): ?string
    {
        if ($this->hide_salary) return 'Competitive';
        if (!$this->min_salary && !$this->max_salary) return null;
        $currency = $this->salary_currency;
        if ($this->min_salary && $this->max_salary) {
            return "{$currency} " . number_format($this->min_salary) . ' - ' . number_format($this->max_salary);
        }
        return "{$currency} " . number_format($this->min_salary ?? $this->max_salary);
    }

    public function getRouteKeyName(): string { return 'slug'; }
}
