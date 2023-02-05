<?php

namespace App\Notifications\Tweets;

use App\Models\Tweet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewTweetAdded extends Notification
{
    use Queueable;

    private Tweet $tweet;
    private string $msg;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Tweet $tweet, string $msg)
    {
        $this->tweet = $tweet;
        $this->msg = $msg;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line($this->msg)
                    ->action('View Tweet', url(route('frontend.tweets.show', $this->tweet->id)))
                    ->line('Thank you for using CaffeineOverflow!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'tweet' => $this->tweet,
            'msg' => $this->msg,
        ];
    }
}
