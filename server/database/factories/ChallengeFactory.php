<?php

namespace Database\Factories;

use App\Enums\CommonStatus;
use App\Enums\StatusChallenge;
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
        return [
            'name' => fake()->title(),
            'status' => StatusChallenge::init->value,
            'description' => fake()->text(200),
        ];
    }
}
