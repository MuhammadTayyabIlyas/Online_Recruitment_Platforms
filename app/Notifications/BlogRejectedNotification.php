<?php

namespace App\Notifications;

use App\Models\Blog;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BlogRejectedNotification extends Notification
{
    use Queueable;

    public function __construct(public Blog $blog) {}

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('Blog Review Update - Action Required')
            ->greeting('Hello ' . $notifiable->name)
            ->line('Your blog post has been reviewed by our admin team.')
            ->line('**Blog Title:** ' . $this->blog->title)
            ->line('**Status:** Requires Revision');

        if ($this->blog->admin_feedback) {
            $message->line('**Admin Feedback:**')
                    ->line($this->blog->admin_feedback);
        }

        $message->action('Review & Edit Your Blog', route('content-creator.blogs.edit', $this->blog))
                ->line('Please make the necessary changes and resubmit your blog for review.')
                ->line('We\'re here to help you create great content. If you have questions, feel free to reach out!');

        return $message;
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'type' => 'blog_rejected',
            'blog_id' => $this->blog->id,
            'blog_title' => $this->blog->title,
            'admin_feedback' => $this->blog->admin_feedback,
            'reviewed_at' => $this->blog->reviewed_at->toDateTimeString(),
        ];
    }
}
