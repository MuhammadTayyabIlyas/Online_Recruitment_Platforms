<?php

namespace App\Notifications;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewApplicationReceived extends Notification
{
    use Queueable;

    public function __construct(public JobApplication $application) {}

    public function via($notifiable): array { return ['mail', 'database']; }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Application - ' . $this->application->job->title)
            ->view('emails.new-application-received', ['application' => $this->application]);
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'new_application',
            'application_id' => $this->application->id,
            'job_title' => $this->application->job->title,
            'applicant_name' => $this->application->user->name,
        ];
    }
}
