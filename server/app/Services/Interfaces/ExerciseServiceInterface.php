<?php

namespace App\Services\Interfaces;

interface ExerciseServiceInterface
{
    public function getExercises();
    public function getExerciseById($id);
    public function getExercisesWithPagination($perPage);
    public function createExercise(array $payload);
    public function updateExercise($id, array $payload);
    public function deleteExercise($id);
}
