<?php

namespace Database\Seeders;

use App\Enums\Level;
use App\Models\Challenge;
use App\Models\ChallengeType;
use App\Models\Exercise;
use App\Supports\Helper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChallengeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ChallengeType::factory()->count(3)->sequence(fn ($sequence) => ['title' => 'challenge_type_' . $sequence->index])->create();
        $challenges = Challenge::factory()->count(5)
            ->sequence(fn ($sequence) => ['title' => 'challenge_' . $sequence->index, 'type_id' => $types->random()])
            ->has(Exercise::factory()->count(50)
                ->sequence(fn ($sequence) => ['level' => Helper::randArray(Level::getNames())]))
            ->hasImage(1)
            ->create();
        // $challenges = Challenge::factory()->count(5)->sequence(fn ($sequence) => ['title' => 'challenge_' . $sequence->index, 'type_id' => $types->random()])->create();
    }
}
