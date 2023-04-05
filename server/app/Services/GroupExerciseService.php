<?php

namespace App\Services;

use App\Models\GroupExercise;
use App\Services\Interfaces\GroupExerciseServiceInterface;

class GroupExerciseService extends BaseService implements GroupExerciseServiceInterface
{
    public function getGroupExercises(bool $typeOption = false)
    {
        if ($typeOption) {
            return GroupExercise::get(['id', 'name']);
        } else {
            return GroupExercise::with('exercises')->get();
        }
    }

    public function createGroupExercise(array $payload)
    {
    }

    public function updateGroupExercise($id, array $payload)
    {
    }

    public function deleteGroupExercise($id)
    {
    }
}
