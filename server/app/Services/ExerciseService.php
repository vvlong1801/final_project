<?php

namespace App\Services;

use App\Models\Exercise;

use App\Services\Interfaces\ExerciseServiceInterface;


class ExerciseService extends BaseService implements ExerciseServiceInterface
{
    public function getExercises()
    {
        return Exercise::all();
    }

    public function getExercisesWithPagination($perPage)
    {
        return Exercise::paginate($perPage);
    }

    public function getExerciseById($id)
    {
        return Exercise::find($id);
    }

    public function createExercise(array $payload)
    {
        $payload['equipment_id'] = \Arr::get($payload, 'equipment', 0);
        $exercise = new Exercise(\Arr::only($payload, ['name', 'level', 'type', 'equipment_id', 'description']));
        $exercise->save();
        if ($payload['gif']) $exercise->gif()->save($payload['gif']);
        if ($payload['image']) $exercise->image()->save($payload['image']);
        if ($payload['video']) $exercise->video()->save($payload['video']);
        $exercise->muscles()->attach(\Arr::get($payload, 'muscles', []));
        return $exercise;
    }

    public function updateExercise($id, array $payload)
    {
        $exercise = Exercise::find($id);
        $payload['equipment_id'] = \Arr::get($payload, 'equipment', 0);
        $exercise->update(\Arr::only($payload, ['name', 'level', 'type', 'equipment_id', 'description']));

        if ($payload['gif']) $exercise->gif()->update($payload['gif']->getAttributes());
        if ($payload['image']) $exercise->image()->update($payload['image']->getAttributes());
        if ($payload['video']) $exercise->video()->update($payload['video']->getAttributes());
        $exercise->muscles()->sync(\Arr::get($payload, 'muscles', []));
        return $exercise;
    }

    public function deleteExercise($ids)
    {
        $result = Exercise::whereIn('id', $ids)->delete();
        if (!$result) throw new \Exception("delete is error");
    }
}
