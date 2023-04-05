<?php

namespace App\Services\Interfaces;

interface GroupExerciseServiceInterface
{
    public function getGroupExercises(bool $typeOption = false);
    public function createGroupExercise(array $payload);
    public function updateGroupExercise($id, array $payload);
    public function deleteGroupExercise($id);
}
