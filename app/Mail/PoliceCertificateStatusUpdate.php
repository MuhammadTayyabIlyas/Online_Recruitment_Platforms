<?php

namespace App\Mail;

use App\Models\PoliceCertificateApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PoliceCertificateStatusUpdate extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The police certificate application instance.
     */
    public PoliceCertificateApplication $application;

    /**
     * The previous status before the update.
     */
    public string $previousStatus;

    /**
     * Create a new message instance.
     */
    public function __construct(PoliceCertificateApplication $application, string $previousStatus)
    {
        $this->application = $application;
        $this->previousStatus = $previousStatus;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Application Status Update - ' . $this->application->application_reference,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.police-certificate.status-update',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
