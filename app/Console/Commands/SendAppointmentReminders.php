<?php

namespace App\Console\Commands;

use App\Mail\AppointmentReminder;
use App\Models\Appointment;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendAppointmentReminders extends Command
{
    protected $signature = 'appointments:send-reminders';
    protected $description = 'Send 24h, 1h, and 15min reminder emails/WhatsApp for upcoming confirmed appointments';

    public function handle(): int
    {
        $tz = config('appointments.timezone', 'Europe/Athens');
        $now = Carbon::now($tz);
        $sent24h = 0;
        $sent1h = 0;
        $sent15m = 0;

        $whatsapp = app(WhatsAppService::class);

        // 24h reminders
        if (config('appointments.reminders.send_24h', true)) {
            $targetDate24h = $now->copy()->addHours(24);

            $appointments = Appointment::where('status', 'confirmed')
                ->whereNull('reminder_24h_sent_at')
                ->whereDate('appointment_date', $targetDate24h->toDateString())
                ->get();

            foreach ($appointments as $appointment) {
                $appointmentTime = Carbon::parse(
                    $appointment->appointment_date->format('Y-m-d') . ' ' . $appointment->start_time,
                    $tz
                );

                $hoursUntil = $now->diffInHours($appointmentTime, false);

                if ($hoursUntil > 0 && $hoursUntil <= 24) {
                    try {
                        $appointment->load('consultationType');

                        Mail::to($appointment->booker_email)
                            ->send(new AppointmentReminder($appointment, '24h'));

                        // WhatsApp reminders to admin and client
                        $whatsapp->sendAppointmentReminderAdmin($appointment, '24 hours');
                        $whatsapp->sendAppointmentReminderClient($appointment, '24 hours');

                        $appointment->update(['reminder_24h_sent_at' => now()]);
                        $sent24h++;
                    } catch (\Exception $e) {
                        $this->error("Failed to send 24h reminder for {$appointment->booking_reference}: {$e->getMessage()}");
                    }
                }
            }
        }

        // 1h reminders
        if (config('appointments.reminders.send_1h', true)) {
            $targetDate1h = $now->copy()->addHour();

            $appointments = Appointment::where('status', 'confirmed')
                ->whereNull('reminder_1h_sent_at')
                ->whereDate('appointment_date', $targetDate1h->toDateString())
                ->get();

            foreach ($appointments as $appointment) {
                $appointmentTime = Carbon::parse(
                    $appointment->appointment_date->format('Y-m-d') . ' ' . $appointment->start_time,
                    $tz
                );

                $minutesUntil = $now->diffInMinutes($appointmentTime, false);

                if ($minutesUntil > 0 && $minutesUntil <= 65) {
                    try {
                        $appointment->load('consultationType');

                        Mail::to($appointment->booker_email)
                            ->send(new AppointmentReminder($appointment, '1h'));

                        // WhatsApp reminders to admin and client
                        $whatsapp->sendAppointmentReminderAdmin($appointment, '1 hour');
                        $whatsapp->sendAppointmentReminderClient($appointment, '1 hour');

                        $appointment->update(['reminder_1h_sent_at' => now()]);
                        $sent1h++;
                    } catch (\Exception $e) {
                        $this->error("Failed to send 1h reminder for {$appointment->booking_reference}: {$e->getMessage()}");
                    }
                }
            }
        }

        // 15-minute reminders (WhatsApp only)
        $targetDate15m = $now->copy()->addMinutes(15);

        $appointments = Appointment::where('status', 'confirmed')
            ->whereNull('reminder_15m_sent_at')
            ->whereDate('appointment_date', $targetDate15m->toDateString())
            ->get();

        foreach ($appointments as $appointment) {
            $appointmentTime = Carbon::parse(
                $appointment->appointment_date->format('Y-m-d') . ' ' . $appointment->start_time,
                $tz
            );

            $minutesUntil = $now->diffInMinutes($appointmentTime, false);

            if ($minutesUntil > 0 && $minutesUntil <= 18) {
                try {
                    $appointment->load('consultationType');

                    // WhatsApp reminders to admin and client
                    $whatsapp->sendAppointmentReminderAdmin($appointment, '15 minutes');
                    $whatsapp->sendAppointmentReminderClient($appointment, '15 minutes');

                    $appointment->update(['reminder_15m_sent_at' => now()]);
                    $sent15m++;
                } catch (\Exception $e) {
                    $this->error("Failed to send 15m reminder for {$appointment->booking_reference}: {$e->getMessage()}");
                }
            }
        }

        $this->info("Sent {$sent24h} 24h, {$sent1h} 1h, and {$sent15m} 15min reminders.");

        return Command::SUCCESS;
    }
}
