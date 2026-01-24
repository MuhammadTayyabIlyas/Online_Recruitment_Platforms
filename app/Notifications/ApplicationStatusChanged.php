<?php

namespace App\Notifications;

use App\Models\JobApplication;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationStatusChanged extends Notification
{
    public function __construct(public JobApplication $application) {}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $status = $this->application->status;

        // Use different email templates based on status
        $viewMap = [
            'shortlisted' => 'emails.application-status.shortlisted',
            'rejected' => 'emails.application-status.rejected',
            'accepted' => 'emails.application-status.accepted',
            'reviewing' => 'emails.application-status.reviewing',
        ];

        $view = $viewMap[$status] ?? 'emails.application-status.general';

        $subjectMap = [
            'shortlisted' => '🎉 Great News! You\'ve been Shortlisted',
            'rejected' => 'Application Status Update',
            'accepted' => '🎊 Congratulations! Job Offer',
            'reviewing' => 'Application Under Review',
            'pending' => 'Application Status Update',
        ];

        $subject = ($subjectMap[$status] ?? 'Application Status Update') . ' - ' . $this->application->job->title;

        return (new MailMessage)
            ->subject($subject)
            ->view($view, ['application' => $this->application]);
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'application_status_changed',
            'application_id' => $this->application->id,
            'job_title' => $this->application->job->title,
            'company_name' => $this->application->job->company->company_name,
            'status' => $this->application->status,
            'message' => $this->getStatusMessage(),
        ];
    }

    protected function getStatusMessage(): string
    {
        return match($this->application->status) {
            'shortlisted' => 'You have been shortlisted for an interview!',
            'rejected' => 'Your application has been reviewed.',
            'accepted' => 'Congratulations! You have been selected for the position.',
            'reviewing' => 'Your application is currently under review.',
            default => 'Your application status has been updated.',
        };
    }
}
