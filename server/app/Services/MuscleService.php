<?php

namespace App\Services;

use App\Models\Muscle;
use App\Services\Interfaces\MuscleServiceInterface;

class MuscleService extends BaseService implements MuscleServiceInterface
{
    public function getMuscles()
    {
        return Muscle::all();
    }

    public function getMusclesWithPagination()
    {
        return  Muscle::paginate(12);
    }

    public function createMuscle(array $payload)
    {

        $muscle = Muscle::create(\Arr::only($payload, ['name', 'description']));

        $muscle->image()->save($payload['image']);

        if ($payload['icon']) {
            $muscle->icon()->save($payload['icon']);
        }
        return $muscle;
    }

    public function updateMuscle($id, array $payload)
    {
        $muscle = Muscle::find($id);
        $muscle->name = \Arr::get($payload, 'name', '');
        $muscle->description = \Arr::get($payload, 'description', '');
        $muscle->save();
        if ($image = \Arr::get($payload, 'image', false)) {
            $muscle->image()->update($image->getAttributes());
        }
        if ($icon = \Arr::get($payload, 'icon', false)) {
            $muscle->icon()->update($icon->getAttributes());
        }

        return $muscle;
    }

    public function deleteMuscle($id)
    {
        Muscle::destroy($id);
    }
}
