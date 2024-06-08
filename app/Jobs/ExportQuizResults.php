<?php

namespace App\Jobs;

use App\Models\QuizAttempt;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\Csv\Writer;
use Illuminate\Support\Facades\Storage;

class ExportQuizResults implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $priority = 1; // Set the default priority level

    public function handle()
    {
            $quizAttempts = QuizAttempt::all();

            $csv = Writer::createFromString('');
            $csv->insertOne(['Member Name', 'Score', 'Passed']);
        
            foreach ($quizAttempts as $attempt) {
                $csv->insertOne([$attempt->member->name, $attempt->score, $attempt->passed ? 'Yes' : 'No']);
            }
        
            $filePath = 'quiz_results.csv';
            Storage::disk('public')->put($filePath, $csv->getContent());
        
            return Storage::disk('public')->download($filePath);
    }
}
