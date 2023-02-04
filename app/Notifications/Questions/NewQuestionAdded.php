<?php

namespace App\Notifications\Questions;

use App\Models\Question;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewQuestionAdded extends Notification
{
    use Queueable;

    private Question $question;
    private string $msg;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Question $question, string $msg)
    {
        $this->question = $question;
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
                    ->action('View Question', url(route('frontend.questions.show', $this->question->id)))
                    ->line('Thank you for using TweetTrust!');
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
            'question' => $this->question,
            'msg' => $this->msg,
        ];
    }
}
