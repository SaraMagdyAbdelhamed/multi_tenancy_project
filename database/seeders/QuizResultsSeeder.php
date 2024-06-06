<?php

namespace Database\Seeders;

use App\Models\QuizAttempt;
use App\Models\Member;
use Illuminate\Database\Seeder;

class QuizResultsSeeder extends Seeder
{
    public function run()
    {
        $members = Member::all();
        QuizAttempt::factory()->count(20000 / $members->count())->create([]);
    }
}
