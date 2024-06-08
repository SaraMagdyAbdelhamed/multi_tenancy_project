<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Quiz;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{

    protected $model = Quiz::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence;
        $slug = Str::slug($title);
    
        $type = $this->faker->randomElement([1, 2]);
        $startTime = $type == 1 ? $this->faker->dateTimeBetween('now', '+1 month') : null;
        $endTime = $type == 1 ? $this->faker->dateTimeBetween('+1 month', '+2 months') : null;
    
        return [
            'title' => $title,
            'slug' => $slug,
            'description' => $this->faker->text(255),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'mark' => $this->faker->randomNumber(2),
            'type' => $type,
        ];
    }
}
