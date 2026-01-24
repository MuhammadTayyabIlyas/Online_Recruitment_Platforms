<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmployerContactNotification extends Notification
{
    use Queueable;

    public function __construct(public User $employer, public string $message) {}

    public function via($notifiable): array { return ['mail', 'database']; }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('An Employer Wants to Connect')
            ->greeting('Hello ' . $notifiable->name)
            ->line('An employer has shown interest in your profile.')
            ->line('Company: ' . ($this->employer->company?->company_name ?? 'N/A'))
            ->line('Message:')
            ->line($this->message)
            ->action('View Your Profile', route('jobseeker.profile.index'))
            ->line('Good luck with your job search!');
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'employer_contact',
            'employer_id' => $this->employer->id,
            'employer_name' => $this->employer->name,
            'company_name' => $this->employer->company?->company_name,
            'message' => $this->message,
        ];
    }
}
