<?php

namespace Database\Factories;

use App\Enums\CommonStatus;
use App\Enums\Level;
use App\Models\Challenge;
use App\Models\Member;
use App\Supports\Helper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $challenges = Challenge::all();
        $members = Member::all();
        return [
            'challenge_id' => $challenges->random()->id,
            'member_id' => $members->random()->id,
            'level' => Helper::randArray(Level::getValues()),
            'total_day' => 30,
            'status' => CommonStatus::active,
            'started_at' => now(),
        ];
    }
}
