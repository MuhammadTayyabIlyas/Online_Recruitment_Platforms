<?php

namespace App\Mail;

use App\Models\PortugalCertificateApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class PortugalCertificateSubmitted extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The Portugal certificate application instance.
     */
    public PortugalCertificateApplication $application;

    /**
     * Create a new message instance.
     */
    public function __construct(PortugalCertificateApplication $application)
    {
        $this->application = $application;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Portugal Criminal Record Certificate Application Received - ' . $this->application->application_reference,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.portugal-certificate.submitted',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        // Attach payment details PDF if it exists
        $paymentDoc = $this->application->documents()
            ->where('document_type', 'payment_details')
            ->first();

        if ($paymentDoc && Storage::disk('private')->exists($paymentDoc->file_path)) {
            $attachments[] = Attachment::fromStorageDisk('private', $paymentDoc->file_path)
                ->as('Payment_Details_' . $this->application->application_reference . '.pdf')
                ->withMime('application/pdf');
        }

        return $attachments;
    }
}
