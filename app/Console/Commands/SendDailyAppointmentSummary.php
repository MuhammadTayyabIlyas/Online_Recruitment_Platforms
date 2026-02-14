<?php

namespace App\Console\Commands;

use App\Mail\DailyAppointmentSummary;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDailyAppointmentSummary extends Command
{
    protected $signature = 'appointments:daily-summary';
    protected $description = 'Send daily summary email of tomorrow\'s appointments to admin';

    public function handle(): int
    {
        $tz = config('appointments.timezone', 'Europe/Athens');
        $tomorrow = Carbon::now($tz)->addDay()->startOfDay();

        $appointments = Appointment::whereDate('appointment_date', $tomorrow)
            ->whereIn('status', ['pending', 'confirmed'])
            ->with('consultationType')
            ->orderBy('start_time')
            ->get();

        $recipient = 'shahpak@gmail.com';

        try {
            Mail::to($recipient)->send(new DailyAppointmentSummary($appointments, $tomorrow));
            $this->info("Daily summary sent to {$recipient} with {$appointments->count()} appointment(s) for {$tomorrow->format('D, M d, Y')}.");
        } catch (\Exception $e) {
            $this->error("Failed to send daily summary: {$e->getMessage()}");
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
