<?php

namespace Database\Seeders;

use App\Enums\Level;
use App\Models\Exercise;
use App\Models\GroupExercise;
use App\Supports\Helper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groupExes = GroupExercise::factory()->count(3)
            ->has(Exercise::factory()->count(20)
                ->sequence(fn ($sequence) => ['level' => Helper::randArray(Level::getNames())]))
            ->hasImage(1)
            ->create();
    }
}
