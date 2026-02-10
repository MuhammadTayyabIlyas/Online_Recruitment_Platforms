<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'type',
        'start_time',
        'end_time',
        'reason',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    public function scopeForDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    public function scopeBlocks($query)
    {
        return $query->where('type', 'block');
    }

    public function scopeOverrides($query)
    {
        return $query->where('type', 'override');
    }

    public function isBlock(): bool
    {
        return $this->type === 'block';
    }

    public function isOverride(): bool
    {
        return $this->type === 'override';
    }
}
