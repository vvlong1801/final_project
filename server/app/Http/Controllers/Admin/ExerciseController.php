<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeleteExerciseRequest;
use App\Http\Requests\Admin\StoreExerciseRequest;
use App\Http\Resources\collections\ExerciseCollection;
use App\Http\Resources\ExerciseResource;
use App\Http\Resources\GroupExerciseResource;
use App\Services\Interfaces\ExerciseServiceInterface;
use App\Services\Interfaces\MediaServiceInterface;

class ExerciseController extends Controller
{
    protected $exerciseService;
    protected $mediaService;

    public function __construct(ExerciseServiceInterface $exerciseService, MediaServiceInterface $mediaService)
    {
        $this->exerciseService = $exerciseService;
        $this->mediaService = $mediaService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $perPage = 0)
    {
        if ($perPage) {
            $exercises = $this->exerciseService->getExercisesWithPagination($perPage);
            return $this->getResponse(new ExerciseCollection($exercises), 'get exercises is success');
        } else {
            $exercises = $this->exerciseService->getExercises();
            return $this->responseOk(ExerciseResource::collection($exercises), 'get exercises is success');
        }
    }

    public function getGroups()
    {
        $groups = $this->exerciseService->getGroupExercises();
        return $this->responseOk(GroupExerciseResource::collection($groups), 'success');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function findById($id)
    {
        $exercise = $this->exerciseService->getExerciseById($id);
        return $this->responseOk(new ExerciseResource($exercise), 'get exercises is success');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(StoreExerciseRequest $request)
    {
        $payload = $request->validated();
        $payload['created_by'] = $request->user()->id;

        try {
            $payload['gif'] = $this->mediaService->createMedia($payload['gif']);
            $payload['image'] = $this->mediaService->createMedia($payload['image']);

            $video = \Arr::get($payload, 'video', false);
            if ($video) {
                $payload['video'] =  $this->mediaService->createMedia($video);
            }

            $result = $this->exerciseService->createExercise($payload);
            return $this->responseOk($result, 'exercise created');
        } catch (\Throwable $th) {
            abort(404, $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.s
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, StoreExerciseRequest $request)
    {
        $payload = $request->validated();
        $payload['created_by'] = $request->user()->id;
        try {
            $payload['gif'] = $this->mediaService->createMedia($payload['gif']);
            $payload['image'] = $this->mediaService->createMedia($payload['image']);

            $video = \Arr::get($payload, 'video', false);
            if ($video) {
                $payload['video'] =  $this->mediaService->createMedia($video);
            }

            $result = $this->exerciseService->updateExercise($id, $payload);
            return $this->responseOk($result, 'exercise updated');
        } catch (\Throwable $th) {
            abort(404, $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(DeleteExerciseRequest $request)
    {
        $ids = \Arr::get($request->validated(), 'ids', []);
        try {
            $this->exerciseService->deleteExercise($ids);
            return $this->responseOk(null, 'exercise deleted', 204);
        } catch (\Throwable $th) {
            abort(400, 'delete exercise is error');
        }
    }
}
