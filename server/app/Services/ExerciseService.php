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

    public function getGroupExercises()
    {
        return GroupExercise::select(['id', 'name'])->get();
    }

    public function getExercisesWithPagination($perPage)
    {
        return Exercise::paginate($perPage);
    }

    public function getExerciseById($id)
    {
        return Exercise::findOrFail($id);
    }

    public function createExercise(array $payload)
    {
        \DB::beginTransaction();
        try {
            $exercise = Exercise::create(\Arr::only($payload, ['name', 'level', 'created_by', 'evaluate_method', 'equipment_id', 'description']));

            $exercise->gif()->save($payload['gif']);
            $exercise->image()->save($payload['image']);
            if ($payload['video']) $exercise->video()->save($payload['video']);

            $exercise->muscles()->attach(\Arr::get($payload, 'muscles', []));

            $groupCollect = collect(\Arr::get($payload, 'group_exercises', []))->groupBy(function ($item, $key) {
                return \Arr::exists($item, 'id') ? 'existed' : 'not_existed';
            });

            if ($groupCollect->get('not_existed') !== null) {
                $notExistedGroups = $groupCollect->get('not_existed')->map(function ($item) use ($payload) {
                    $item['created_by'] = $payload['created_by'];
                    return $item;
                })->all();
                $exercise->groupExercises()->createMany($notExistedGroups);
            }

            if ($groupCollect->get('existed') !== null) {
                $exercise->groupExercises()->attach($groupCollect->get('existed')->pluck('id')->all());
            }

            \DB::commit();
            return true;
        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;
        }
    }

    public function updateExercise($id, array $payload)
    {
        \DB::beginTransaction();
        try {
            $exercise = Exercise::findOrFail($id);
            $exercise->update(\Arr::only($payload, ['name', 'level', 'created_by', 'evaluate_method', 'equipment_id', 'description']));
            $exercise->gif()->update($payload['gif']->getAttributes());
            $exercise->image()->update($payload['image']->getAttributes());
            if ($payload['video']) $exercise->video()->update($payload['video']->getAttributes());

            $exercise->muscles()->sync(\Arr::get($payload, 'muscles', []));

            $groupCollect = collect(\Arr::get($payload, 'group_exercises', []))->groupBy(function ($item, $key) {
                return \Arr::exists($item, 'id') ? 'existed' : 'not_existed';
            });


            if ($groupCollect->get('not_existed') !== null) {
                $notExistedGroups = $groupCollect->get('not_existed')->map(function ($item) use ($payload) {
                    $item['created_by'] = $payload['created_by'];
                    return $item;
                })->all();
                $exercise->groupExercises()->createMany($notExistedGroups);
            }
            if ($groupCollect->get('existed') !== null) {
                // dd($exercise->groupExercises()->sync($groupCollect->get('existed')->pluck('id')->all()));
                $exercise->groupExercises()->sync($groupCollect->get('existed')->pluck('id')->all());
            }
            \DB::commit();
            return true;
        } catch (\Throwable $th) {
            \DB::rollback();
            throw $th;
        }


        return $exercise;
    }

    public function deleteExercise($ids)
    {
        $result = Exercise::whereIn('id', $ids)->delete();
        if (!$result) throw new \Exception("delete is error");
    }
}
