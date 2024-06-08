<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class QuizReminderNotification extends Notification
{
    use Queueable;

    protected $quiz;
    protected $quizAttemptLink;

    public function __construct($quiz, $quizAttemptLink)
    {
        $this->quiz = $quiz;
        $this->quizAttemptLink = $quizAttemptLink;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $quizName = $this->quiz->name;
        $quizAttemptLink = $this->quizAttemptLink;

        return (new MailMessage)
            ->subject('Quiz Reminder')
            ->line('This is a reminder to take the quiz: ' . $quizName)
            ->line('The quiz is starting soon. Please click the button below to start your attempt.')
            ->action('Start Quiz', $quizAttemptLink);
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
