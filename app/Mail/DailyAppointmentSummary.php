<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class DailyAppointmentSummary extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Collection $appointments,
        public Carbon $date
    ) {}

    public function envelope(): Envelope
    {
        $count = $this->appointments->count();
        $dateStr = $this->date->format('D, M d');

        return new Envelope(
            subject: $count > 0
                ? "Tomorrow's Schedule: {$count} appointment(s) - {$dateStr}"
                : "No appointments scheduled for tomorrow - {$dateStr}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.appointments.daily-summary',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
