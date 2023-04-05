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
        $challenges = Challenge::factory()->count(5)
            ->hasImage(1)
            ->create();
    }
}
