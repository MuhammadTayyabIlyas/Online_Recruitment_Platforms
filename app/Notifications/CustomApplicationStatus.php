<?php

namespace App\Notifications;

use App\Models\JobApplication;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomApplicationStatus extends Notification
{
    public function __construct(private JobApplication $application, private ?string $message = null)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $statusLabel = $this->application->status ? ucfirst(str_replace('_', ' ', $this->application->status)) : 'Updated';

        $mail = (new MailMessage)
            ->subject("Your application status: {$statusLabel}")
            ->greeting("Hi {$notifiable->name},")
            ->line("The status of your application for \"{$this->application->job->title}\" has been updated to {$statusLabel}.");

        if ($this->message) {
            $mail->line('Message from the employer:')->line($this->message);
        }

        $mail->action('View Application', url(route('jobseeker.applications.show', $this->application)));

        return $mail->line('Thank you for applying.');
    }
}
