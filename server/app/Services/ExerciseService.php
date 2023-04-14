<?php

namespace App\Services;

use App\Models\Exercise;
use App\Models\GroupExercise;
use App\Services\Interfaces\ExerciseServiceInterface;


class ExerciseService extends BaseService implements ExerciseServiceInterface
{
    public function getExercises()
    {
        return Exercise::with(['gif', 'image', 'video', 'groupExercises'])->get();
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
        \DB::beginTransaction();
        try {
            $exercise = Exercise::create(\Arr::only($payload, ['name', 'level', 'type', 'equipment_id', 'description']));

            $exercise->gif()->save($payload['gif']);
            $exercise->image()->save($payload['image']);
            if ($payload['video']) $exercise->video()->save($payload['video']);

            $exercise->muscles()->attach(\Arr::get($payload, 'muscles', []));
            dd($payload['groupExercises']);
            $exercise->groupExercises()->attach(\Arr::get($payload, 'groupExercises', []));

            \DB::commit();
            return true;
        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;
        }
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
        $exercise->groupExercises()->sync(\Arr::get($payload, 'groupExercises', []));

        return $exercise;
    }

    public function deleteExercise($ids)
    {
        $result = Exercise::whereIn('id', $ids)->delete();
        if (!$result) throw new \Exception("delete is error");
    }
}
