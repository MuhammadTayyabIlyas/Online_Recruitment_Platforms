<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\AppointmentBlock;
use App\Models\AppointmentSchedule;
use App\Models\ConsultationType;
use App\Mail\AppointmentBooked;
use App\Mail\AppointmentBookedAdmin;
use App\Mail\AppointmentCancelled;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AppointmentService
{
    public function getAvailableSlots(ConsultationType $type, Carbon $date): array
    {
        $tz = config('appointments.timezone', 'Europe/Athens');
        $dayOfWeek = $date->dayOfWeek; // 0=Sunday

        // Check if the entire date is blocked
        $isBlocked = AppointmentBlock::forDate($date)->blocks()->exists();
        if ($isBlocked) {
            return [];
        }

        // Check for overrides on this date
        $overrides = AppointmentBlock::forDate($date)->overrides()->get();

        if ($overrides->isNotEmpty()) {
            // Use override windows instead of regular schedule
            $windows = $overrides->map(fn ($o) => [
                'start' => $o->start_time,
                'end' => $o->end_time,
            ])->toArray();
        } else {
            // Use regular weekly schedule
            $schedules = AppointmentSchedule::active()->forDay($dayOfWeek)->get();
            if ($schedules->isEmpty()) {
                return [];
            }

            $windows = $schedules->map(fn ($s) => [
                'start' => $s->start_time,
                'end' => $s->end_time,
            ])->toArray();
        }

        // Generate all possible slots from available windows
        $slotDuration = $type->duration_minutes;
        $buffer = $type->buffer_minutes;
        $slots = [];

        foreach ($windows as $window) {
            $windowStart = Carbon::parse($date->format('Y-m-d') . ' ' . $window['start'], $tz);
            $windowEnd = Carbon::parse($date->format('Y-m-d') . ' ' . $window['end'], $tz);

            $slotStart = $windowStart->copy();

            while ($slotStart->copy()->addMinutes($slotDuration)->lte($windowEnd)) {
                $slotEnd = $slotStart->copy()->addMinutes($slotDuration);

                $slots[] = [
                    'start' => $slotStart->format('H:i'),
                    'end' => $slotEnd->format('H:i'),
                ];

                $slotStart->addMinutes($slotDuration + $buffer);
            }
        }

        // Remove slots that are already booked
        $bookedSlots = Appointment::forDate($date)
            ->active()
            ->select('start_time', 'end_time')
            ->get();

        $slots = array_filter($slots, function ($slot) use ($bookedSlots) {
            foreach ($bookedSlots as $booked) {
                $bookedStart = Carbon::parse($booked->start_time)->format('H:i');
                $bookedEnd = Carbon::parse($booked->end_time)->format('H:i');

                // Check for overlap
                if ($slot['start'] < $bookedEnd && $slot['end'] > $bookedStart) {
                    return false;
                }
            }
            return true;
        });

        // Remove past slots if date is today
        if ($date->isToday()) {
            $now = Carbon::now($tz)->format('H:i');
            $slots = array_filter($slots, fn ($slot) => $slot['start'] > $now);
        }

        return array_values($slots);
    }

    public function getAvailableDatesForMonth(ConsultationType $type, int $year, int $month): array
    {
        $tz = config('appointments.timezone', 'Europe/Athens');
        $start = Carbon::create($year, $month, 1, 0, 0, 0, $tz);
        $end = $start->copy()->endOfMonth();
        $today = Carbon::now($tz)->startOfDay();
        $maxDate = $today->copy()->addDays($type->max_advance_days);

        $dates = [];
        $current = $start->copy();

        // Clamp to today or start of month
        if ($current->lt($today)) {
            $current = $today->copy();
        }

        // Clamp to max advance date
        if ($end->gt($maxDate)) {
            $end = $maxDate;
        }

        while ($current->lte($end)) {
            $slots = $this->getAvailableSlots($type, $current);
            if (count($slots) > 0) {
                $dates[$current->format('Y-m-d')] = count($slots);
            }
            $current->addDay();
        }

        return $dates;
    }

    public function isSlotAvailable(ConsultationType $type, Carbon $date, string $startTime, string $endTime): bool
    {
        // Check for overlapping active appointments
        return !Appointment::forDate($date)
            ->active()
            ->where(function ($q) use ($startTime, $endTime) {
                $q->where(function ($inner) use ($startTime, $endTime) {
                    $inner->where('start_time', '<', $endTime)
                        ->where('end_time', '>', $startTime);
                });
            })
            ->exists();
    }

    public function createAppointment(array $data): Appointment
    {
        return DB::transaction(function () use ($data) {
            $type = ConsultationType::findOrFail($data['consultation_type_id']);
            $date = Carbon::parse($data['appointment_date']);
            $startTime = $data['start_time'];
            $endTime = $data['end_time'];

            // Double-check availability with a lock
            $conflicting = Appointment::forDate($date)
                ->active()
                ->where(function ($q) use ($startTime, $endTime) {
                    $q->where('start_time', '<', $endTime)
                        ->where('end_time', '>', $startTime);
                })
                ->lockForUpdate()
                ->exists();

            if ($conflicting) {
                throw new \Exception('This time slot is no longer available. Please select another slot.');
            }

            $isFree = $type->is_free;
            $autoConfirmFree = config('appointments.auto_confirm_free', true);

            $appointment = Appointment::create([
                'consultation_type_id' => $type->id,
                'user_id' => $data['user_id'] ?? null,
                'booker_name' => $data['booker_name'],
                'booker_email' => $data['booker_email'],
                'booker_phone' => $data['booker_phone'] ?? null,
                'appointment_date' => $date,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'duration_minutes' => $type->duration_minutes,
                'meeting_format' => $data['meeting_format'] ?? 'online',
                'office_key' => $data['office_key'] ?? null,
                'price' => $type->price,
                'currency' => $type->currency,
                'is_free' => $isFree,
                'payment_status' => $isFree ? 'not_required' : 'pending',
                'status' => ($isFree && $autoConfirmFree) ? 'confirmed' : 'pending',
                'notes' => $data['notes'] ?? null,
            ]);

            // Send confirmation emails
            try {
                $appointment->load('consultationType');
                Mail::to($appointment->booker_email)->send(new AppointmentBooked($appointment));
                Mail::to(config('placemenet.support_email', 'support@placemenet.net'))
                    ->send(new AppointmentBookedAdmin($appointment));
            } catch (\Exception $e) {
                // Log but don't block booking
            }

            // Send WhatsApp notification to admin
            try {
                $whatsapp = app(WhatsAppService::class);
                $whatsapp->sendAppointmentBookedNotification($appointment);
            } catch (\Exception $e) {
                // Log but don't block booking
            }

            return $appointment;
        });
    }

    public function cancelAppointment(Appointment $appointment, string $reason = null, string $cancelledBy = 'user'): Appointment
    {
        $appointment->update([
            'status' => 'cancelled',
            'cancellation_reason' => $reason,
            'cancelled_at' => now(),
            'cancelled_by' => $cancelledBy,
        ]);

        // Send cancellation emails
        try {
            $appointment->load('consultationType');
            Mail::to($appointment->booker_email)->send(new AppointmentCancelled($appointment));
            Mail::to(config('placemenet.support_email', 'support@placemenet.net'))
                ->send(new AppointmentCancelled($appointment));
        } catch (\Exception $e) {
            // Log but don't block
        }

        return $appointment->fresh();
    }

    public function confirmAppointment(Appointment $appointment): Appointment
    {
        $appointment->update(['status' => 'confirmed']);
        return $appointment->fresh();
    }

    public function completeAppointment(Appointment $appointment): Appointment
    {
        $appointment->update(['status' => 'completed']);
        return $appointment->fresh();
    }

    public function markNoShow(Appointment $appointment): Appointment
    {
        $appointment->update(['status' => 'no_show']);
        return $appointment->fresh();
    }

    public function markPaid(Appointment $appointment, string $paymentIntentId): Appointment
    {
        $autoConfirm = config('appointments.auto_confirm_paid', true);

        $appointment->update([
            'payment_status' => 'completed',
            'stripe_payment_intent_id' => $paymentIntentId,
            'paid_at' => now(),
            'status' => $autoConfirm ? 'confirmed' : $appointment->status,
        ]);

        return $appointment->fresh();
    }
}
