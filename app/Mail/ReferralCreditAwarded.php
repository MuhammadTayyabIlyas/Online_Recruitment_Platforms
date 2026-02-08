<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReferralCreditAwarded extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $recipient;
    public User $otherUser;
    public float $amount;
    public bool $isReferrer;

    public function __construct(User $recipient, User $otherUser, float $amount, bool $isReferrer)
    {
        $this->recipient = $recipient;
        $this->otherUser = $otherUser;
        $this->amount = $amount;
        $this->isReferrer = $isReferrer;
    }

    public function envelope(): Envelope
    {
        $subject = $this->isReferrer
            ? 'You earned a referral bonus!'
            : 'Welcome bonus credited to your wallet!';

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.referral-credit-awarded',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
