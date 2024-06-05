<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Quiz;

class QuizResult extends Mailable
{
    use Queueable, SerializesModels;

    public $quiz;
    public $result;

    /**
     * Create a new message instance.
     *
     * @param Quiz $quiz
     * @param Result $result
     * @return void
     */
    public function __construct(Quiz $quiz, Array $result)
    {
        $this->quiz = $quiz;
        $this->result = $result;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Quiz Result')
            ->markdown('emails.quiz_result');
    }
}