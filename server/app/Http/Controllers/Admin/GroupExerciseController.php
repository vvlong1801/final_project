<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\GroupExerciseResource;
use App\Services\Interfaces\GroupExerciseServiceInterface;
use Illuminate\Http\Request;

class GroupExerciseController extends Controller
{
    protected $groupExerciseService;

    public function __construct(GroupExerciseServiceInterface $groupExerciseService)
    {
        $this->groupExerciseService = $groupExerciseService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $typeOption = $request->has('option');
        $groupExercises = $this->groupExerciseService->getGroupExercises($typeOption);
        return $this->responseOk(GroupExerciseResource::collection($groupExercises), 'success');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
