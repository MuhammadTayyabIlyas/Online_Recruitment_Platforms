<?php

namespace App\Mail;

use App\Models\AuthorizedPartner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class PartnerApproved extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public AuthorizedPartner $partner;

    public function __construct(AuthorizedPartner $partner)
    {
        $this->partner = $partner;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your PlaceMeNet Authorized Partner Certificate - ' . $this->partner->reference_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.partner-approved',
        );
    }

    /**
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        if ($this->partner->certificate_path && Storage::disk('private')->exists($this->partner->certificate_path)) {
            $attachments[] = Attachment::fromStorageDisk('private', $this->partner->certificate_path)
                ->as('Partner_Certificate_' . $this->partner->reference_number . '.pdf')
                ->withMime('application/pdf');
        }

        return $attachments;
    }
}
