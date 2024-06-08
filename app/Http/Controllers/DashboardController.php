<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\QuizAttempt;
use App\Models\Member;
class DashboardController extends Controller
{
    public function index()
    {
        

        $memberCount = Member::count();
        $attemptCount = QuizAttempt::count();
        $passRate = $this->calculatePassRate();
        $failRate = $this->calculateFailRate();
        $averageScore = $this->calculateAverageScore();
        $averageTime = $this->calculateAverageTime();

        return view('tenant.dashboard.index', compact(
            'memberCount',
            'attemptCount',
            'passRate',
            'failRate',
            'averageScore',
            'averageTime'
        ));
    }

    private function calculatePassRate()
    {
        $totalAttempts = QuizAttempt::count();
        $passAttempts = QuizAttempt::where('passed', 1)->count();

        if ($totalAttempts > 0) {
            $passRate = ($passAttempts / $totalAttempts) * 100;
        } else {
            $passRate = 0;
        }

        return $passRate;
    }

    private function calculateFailRate()
    {
        $totalAttempts = QuizAttempt::count();
        $failAttempts = QuizAttempt::where('passed', 0)->count();

        if ($totalAttempts > 0) {
            $failRate = ($failAttempts / $totalAttempts) * 100;
        } else {
            $failRate = 0;
        }

        return $failRate;
    }

    private function calculateAverageScore()
    {
        $averageScore = QuizAttempt::avg('score');

        return $averageScore;
    }

    private function calculateAverageTime()
    {
        $averageTimeTaken = QuizAttempt::join('quizzes', 'quiz_attempts.quiz_id', '=', 'quizzes.id')
        ->where('quizzes.type', 1)
        ->avg('time_taken');

        return $averageTimeTaken;
    }
}
