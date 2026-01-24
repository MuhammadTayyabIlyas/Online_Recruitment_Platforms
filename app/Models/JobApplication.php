<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class JobApplication extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid', 'job_id', 'user_id', 'cover_letter', 'resume_path',
        'expected_salary', 'available_from', 'answers', 'status',
        'notes', 'rating', 'applied_at', 'reviewed_at', 'reviewed_by',
    ];

    protected $casts = [
        'answers' => 'array',
        'expected_salary' => 'decimal:2',
        'available_from' => 'date',
        'applied_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($app) => $app->uuid = $app->uuid ?? Str::uuid());
    }

    public function job(): BelongsTo { return $this->belongsTo(Job::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function reviewer(): BelongsTo { return $this->belongsTo(User::class, 'reviewed_by'); }

    public function scopePending($q) { return $q->where('status', 'pending'); }
    public function scopeShortlisted($q) { return $q->where('status', 'shortlisted'); }

    public function getResumeUrlAttribute(): ?string
    {
        return $this->resume_path ? asset('storage/' . $this->resume_path) : null;
    }
}
