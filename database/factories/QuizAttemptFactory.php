<?php

namespace Database\Factories;

use App\Models\QuizAttempt;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class QuizAttemptFactory extends Factory
{
    protected $model = QuizAttempt::class;

    public function definition()
    {
        return [
            'member_id' => $this->faker->randomElement(\App\Models\Member::pluck('id')),
            'quiz_id' => $this->faker->randomElement(\App\Models\Quiz::pluck('id')),
            'score' => $this->faker->numberBetween(0, 100),
            'passed' => $this->faker->boolean,
            'attempt_number' => $this->faker->numberBetween(0, 10),
            'link' => Str::random(10)
        ]; 
    }
}