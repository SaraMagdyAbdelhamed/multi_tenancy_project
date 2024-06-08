<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Choice;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Choice>
 */
class ChoiceFactory extends Factory
{

    protected $model = Choice::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->word,
            'is_correct' => false,
            'order' => $this->faker->randomNumber(2),
            'description' => $this->faker->text(255),
            'explanation' => $this->faker->text(255),
        ];
    }
}
