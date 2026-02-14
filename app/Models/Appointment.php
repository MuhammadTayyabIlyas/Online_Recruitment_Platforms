<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_reference',
        'consultation_type_id',
        'user_id',
        'booker_name',
        'booker_email',
        'booker_phone',
        'appointment_date',
        'start_time',
        'end_time',
        'duration_minutes',
        'meeting_format',
        'office_key',
        'meeting_link',
        'price',
        'currency',
        'is_free',
        'payment_status',
        'stripe_payment_intent_id',
        'paid_at',
        'status',
        'notes',
        'admin_notes',
        'cancellation_reason',
        'cancelled_at',
        'cancelled_by',
        'reminder_24h_sent_at',
        'reminder_1h_sent_at',
        'reminder_15m_sent_at',
    ];

    protected function casts(): array
    {
        return [
            'appointment_date' => 'date',
            'price' => 'decimal:2',
            'is_free' => 'boolean',
            'paid_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'reminder_24h_sent_at' => 'datetime',
            'reminder_1h_sent_at' => 'datetime',
            'reminder_15m_sent_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Appointment $appointment) {
            if (empty($appointment->booking_reference)) {
                $appointment->booking_reference = self::generateReference();
            }
        });
    }

    public static function generateReference(): string
    {
        $prefix = config('appointments.reference_prefix', 'APT');
        $length = config('appointments.reference_length', 8);

        do {
            $reference = $prefix . '-' . strtoupper(Str::random($length));
        } while (self::where('booking_reference', $reference)->exists());

        return $reference;
    }

    public function consultationType(): BelongsTo
    {
        return $this->belongsTo(ConsultationType::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes

    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', now()->toDateString())
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_date')
            ->orderBy('start_time');
    }

    public function scopePast($query)
    {
        return $query->where(function ($q) {
            $q->where('appointment_date', '<', now()->toDateString())
                ->orWhereIn('status', ['completed', 'cancelled', 'no_show', 'rescheduled']);
        })->orderByDesc('appointment_date')->orderByDesc('start_time');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'confirmed']);
    }

    public function scopeForDate($query, $date)
    {
        return $query->whereDate('appointment_date', $date);
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByEmail($query, string $email)
    {
        return $query->where('booker_email', $email);
    }

    // Helper methods

    public function canCancel(): bool
    {
        if (!in_array($this->status, ['pending', 'confirmed'])) {
            return false;
        }

        $minHours = config('appointments.min_cancel_hours', 2);
        $appointmentDateTime = $this->appointment_date->copy()
            ->setTimeFromTimeString($this->start_time);

        return now()->diffInHours($appointmentDateTime, false) >= $minHours;
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'completed';
    }

    public function requiresPayment(): bool
    {
        return !$this->is_free && $this->payment_status === 'pending';
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'blue',
            'cancelled' => 'red',
            'completed' => 'green',
            'no_show' => 'gray',
            'rescheduled' => 'purple',
            default => 'gray',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'cancelled' => 'Cancelled',
            'completed' => 'Completed',
            'no_show' => 'No Show',
            'rescheduled' => 'Rescheduled',
            default => ucfirst($this->status),
        };
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return match ($this->payment_status) {
            'not_required' => 'Not Required',
            'pending' => 'Pending',
            'completed' => 'Paid',
            'refunded' => 'Refunded',
            default => ucfirst($this->payment_status),
        };
    }

    public function getOfficeAttribute(): ?array
    {
        if (!$this->office_key) {
            return null;
        }

        $offices = config('placemenet.offices', []);
        return collect($offices)->firstWhere('key', $this->office_key);
    }

    public function getFormattedTimeAttribute(): string
    {
        $start = \Carbon\Carbon::parse($this->start_time)->format('H:i');
        $end = \Carbon\Carbon::parse($this->end_time)->format('H:i');
        return "{$start} - {$end}";
    }
}
