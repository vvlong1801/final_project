<?php

namespace App\Services;

use App\Imports\MusclesImport;
use App\Models\Challenge;
use App\Models\Exercise;
use App\Services\Interfaces\ChallengeServiceInterface;
use App\Services\Interfaces\ExerciseServiceInterface;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ExerciseService extends BaseService implements ExerciseServiceInterface
{
    public function getExercisesWithPagination()
    {
        return  Exercise::paginate(10);
    }
    public function importMuscle($fileName)
    {

    }

    public function update(array $data)
    {
    }
}
