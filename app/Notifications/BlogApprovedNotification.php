<?php

namespace App\Notifications;

use App\Models\Blog;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BlogApprovedNotification extends Notification
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
        return (new MailMessage)
            ->subject('Your Blog Has Been Approved! 🎉')
            ->greeting('Hello ' . $notifiable->name)
            ->line('Great news! Your blog post has been approved and is now live on PlaceMeNet.')
            ->line('**Blog Title:** ' . $this->blog->title)
            ->line('**Category:** ' . $this->blog->category->name)
            ->line('**Published:** ' . $this->blog->published_at->format('F d, Y \a\t h:i A'))
            ->action('View Your Blog', route('blogs.show', $this->blog->slug))
            ->line('Your blog is now visible to thousands of visitors. Thank you for your valuable contribution!')
            ->line('Keep sharing great content to build your audience and establish your authority.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'type' => 'blog_approved',
            'blog_id' => $this->blog->id,
            'blog_title' => $this->blog->title,
            'blog_slug' => $this->blog->slug,
            'published_at' => $this->blog->published_at->toDateTimeString(),
        ];
    }
}
