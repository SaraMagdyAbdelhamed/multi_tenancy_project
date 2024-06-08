<?php

namespace App\Jobs;

use App\Models\Quiz;
use App\Notifications\QuizReminderNotification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use App\Models\QuizAttempt;
use App\Models\Tenant;

class QuizReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $priority = 2; // Set the default priority level


    public function handle()
    {
        $tenants = Tenant::get(); 

        foreach ($tenants as $tenant) {
            tenancy()->initialize($tenant);
            $quizzes = Quiz::all();

            foreach ($quizzes as $quiz) {
                $start_time = Carbon::parse($quiz->start_time);
                $reminderTime = $start_time->subMinutes(30); // Set the reminder time (30 minutes before the quiz start time)

                if (Carbon::now()->lte($reminderTime)) {
                    // Generate and attach the unique link for each member's quiz attempt
                    foreach ($members as $member) {
                        $quizAttempt = QuizAttempt::where('quiz_id', $quiz->id)
                            ->where('member_id', $member->id)
                            ->first();

                        $quizAttemptLink = route('quizes.member', ['link' => $quizAttempt->link]);

                        // Send the reminder notification to the member with the unique link
                        Notification::send($member, new QuizReminderNotification($quiz, $quizAttemptLink));
                    }
                }
            }
        }
    }
}
