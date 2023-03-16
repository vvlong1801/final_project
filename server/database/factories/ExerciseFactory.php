<?php

namespace Database\Factories;

use App\Enums\Level;
use App\Supports\Helper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exercise>
 */
class ExerciseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->text(20),
            'level' => Helper::randArray(Level::getNames()),
            'kcal' => random_int(10, 100) * 0.1,
            'mode_time' => random_int(5, 50),
            'description' => fake()->text(100),
            // 'gif_url' => fake()->url(),
            // 'video_url' => fake()->url(),
        ];
    }
}
