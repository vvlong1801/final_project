<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\MusclesImport;
use App\Services\Interfaces\ExerciseServiceInterface;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MuscleController extends Controller
{
    protected $exerciseService;

    public function __construct(ExerciseServiceInterface $exerciseService)
    {
        $this->exerciseService = $exerciseService;
    }
    public function import(array $data)
    {
        dd($data['import_file']);
        $this->exerciseService->importMuscle($data);
    }
}
