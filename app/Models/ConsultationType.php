<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultationType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'duration_minutes',
        'buffer_minutes',
        'price',
        'currency',
        'is_free',
        'allows_online',
        'allows_in_person',
        'is_active',
        'sort_order',
        'max_advance_days',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_free' => 'boolean',
            'allows_online' => 'boolean',
            'allows_in_person' => 'boolean',
            'is_active' => 'boolean',
            'duration_minutes' => 'integer',
            'buffer_minutes' => 'integer',
            'sort_order' => 'integer',
            'max_advance_days' => 'integer',
        ];
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function getFormattedPriceAttribute(): string
    {
        if ($this->is_free) {
            return 'Free';
        }

        return number_format($this->price, 2) . ' ' . $this->currency;
    }

    public function getFormattedDurationAttribute(): string
    {
        if ($this->duration_minutes >= 60) {
            $hours = floor($this->duration_minutes / 60);
            $mins = $this->duration_minutes % 60;
            return $mins > 0 ? "{$hours}h {$mins}min" : "{$hours}h";
        }

        return "{$this->duration_minutes} min";
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
