<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGroupExerciseRequest;
use App\Http\Resources\GroupExerciseResource;
use App\Services\Interfaces\GroupExerciseServiceInterface;
use App\Services\Interfaces\MediaServiceInterface;
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
    public function index()
    {
        $groupExercises = $this->groupExerciseService->getGroupExercises();
        return $this->responseOk($groupExercises, 'success');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StoreGroupExerciseRequest $request,
        MediaServiceInterface $mediaService
    ) {
        $payload = $request->validated();
        $payload['image'] = $mediaService->createMedia($payload['image']);
        $groupExercise = $this->groupExerciseService->createGroupExercise($payload);
        return $this->responseOk($groupExercise, 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $groupExercise = $this->groupExerciseService->getGroupExerciseById($id);
            return $this->responseOk(new GroupExerciseResource($groupExercise), 'success');
        } catch (\Throwable $th) {
            abort(400, $th->getMessage());
        }
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
