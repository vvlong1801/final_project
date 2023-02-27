<?php

namespace Database\Factories;

use App\Enums\CommonStatus;
use App\Models\ChallengeType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Challenge>
 */
class ChallengeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // dd(CommonStatus::active->value);
        return [
            'title' => fake()->title(),
            'type_id' => ChallengeType::factory(),
            'status' => CommonStatus::active->name,
            'description' => fake()->text(200),
        ];
    }
}
