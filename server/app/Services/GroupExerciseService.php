<?php

namespace App\Services;

use App\Models\GroupExercise;
use App\Services\Interfaces\GroupExerciseServiceInterface;
use Exception;

class GroupExerciseService extends BaseService implements GroupExerciseServiceInterface
{
    public function getGroupExercises()
    {
        return GroupExercise::select(['id', 'name'])->with('image')->get();
    }

    public function getGroupExerciseById($id)
    {
        $result =  GroupExercise::with(['exercises', 'image'])->findOrFail($id);
        if (!$result->count()) {
            throw new Exception("not found data by id = " . $id, 1);
        }
        return $result;
    }

    public function createGroupExercise(array $payload)
    {
        $groupExercise = GroupExercise::create(\Arr::only($payload, ['name', 'description']));
        $groupExercise->image()->save($payload['image']);
        $groupExercise->exercises()->attach(\Arr::get($payload, 'exercises', []));
        return $groupExercise;
    }

    public function updateGroupExercise($id, array $payload)
    {
    }

    public function deleteGroupExercise($id)
    {
    }
}
