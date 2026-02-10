<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentReminder extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Appointment $appointment,
        public string $reminderType = '24h' // '24h' or '1h'
    ) {}

    public function envelope(): Envelope
    {
        $prefix = $this->reminderType === '1h' ? 'Starting Soon' : 'Tomorrow';
        return new Envelope(
            subject: "Appointment {$prefix} - {$this->appointment->booking_reference}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.appointments.reminder',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
