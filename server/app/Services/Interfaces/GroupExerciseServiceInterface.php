<?php

namespace App\Services\Interfaces;

interface GroupExerciseServiceInterface
{
    public function getGroupExercises();
    public function getGroupExerciseById($id);
    public function createGroupExercise(array $payload);
    public function updateGroupExercise($id, array $payload);
    public function deleteGroupExercise($id);
}
