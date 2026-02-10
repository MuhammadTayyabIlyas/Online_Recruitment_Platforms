<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentMeetingLink extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Appointment $appointment
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Meeting Link for Your Appointment - ' . $this->appointment->booking_reference,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.appointments.meeting-link',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
