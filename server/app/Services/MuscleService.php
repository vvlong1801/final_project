<?php

namespace App\Services;

use App\Models\Muscle;
use App\Services\Interfaces\MuscleServiceInterface;
use App\Supports\S3Helper;

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
        // if ($image = \Arr::get($payload, 'image', '')) {
        //     S3Helper::moveTempToLegalBucket($image);
        // }
        // if ($icon = \Arr::get($payload, 'icon', '')) {
        //     S3Helper::moveTempToLegalBucket($icon);
        // }
        return Muscle::create($payload);
    }

    public function updateMuscle($id, array $payload)
    {
        return Muscle::where('id', $id)->update($payload);
    }

    public function deleteMuscle($id)
    {
        Muscle::destroy($id);
    }
}
