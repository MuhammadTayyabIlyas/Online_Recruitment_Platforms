<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobAlert extends Model
{
    protected $fillable = [
        'user_id', 'name', 'keywords', 'category_id', 'location',
        'job_type_id', 'employment_type_id', 'min_salary',
        'frequency', 'is_active', 'last_sent_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'min_salary' => 'decimal:2',
        'last_sent_at' => 'datetime',
    ];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function category(): BelongsTo { return $this->belongsTo(Category::class); }
    public function jobType(): BelongsTo { return $this->belongsTo(JobType::class); }
    public function employmentType(): BelongsTo { return $this->belongsTo(EmploymentType::class); }

    public function scopeActive($q) { return $q->where('is_active', true); }
    public function scopeDaily($q) { return $q->where('frequency', 'daily'); }
    public function scopeWeekly($q) { return $q->where('frequency', 'weekly'); }
}
