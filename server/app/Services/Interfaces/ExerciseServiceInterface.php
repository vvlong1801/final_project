<?php

namespace App\Services\Interfaces;

interface ExerciseServiceInterface
{
    public function importMuscle($file);

    public function update(array $update);

    public function getExercisesWithPagination();
}
