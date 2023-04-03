<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeleteExerciseRequest;
use App\Http\Requests\Admin\StoreExerciseRequest;
use App\Http\Resources\collections\ExerciseCollection;
use App\Http\Resources\ExerciseResource;
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
            return $this->getResponse(ExerciseResource::collection($exercises), 'get exercises is success');
        }
        // ExerciseResource::collection($exercises)
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function findById($id)
    {
        $exercise = $this->exerciseService->getExerciseById($id);
        return $this->getResponse(new ExerciseResource($exercise), 'get exercises is success');
        // ExerciseResource::collection($exercises)
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(StoreExerciseRequest $request)
    {
        $payload = $request->validated();
        $gif = \Arr::get($payload, 'gif', false);
        $video = \Arr::get($payload, 'video', false);
        $image = \Arr::get($payload, 'image', false);

        $payload['gif'] = $gif ? $this->mediaService->createMedia($gif) : null;
        $payload['video'] = $video ? $this->mediaService->createMedia($video) : null;
        $payload['image'] = $image ? $this->mediaService->createMedia($image) : null;

        $exercise = $this->exerciseService->createExercise($payload);
        return $this->getResponse(new ExerciseResource($exercise), 'muscle created');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, StoreExerciseRequest $request)
    {
        $payload = $request->validated();
        $gif = \Arr::get($payload, 'gif', false);
        $video = \Arr::get($payload, 'video', false);
        $image = \Arr::get($payload, 'image', false);

        $payload['gif'] = $gif ? $this->mediaService->createMedia($gif) : null;
        $payload['video'] = $video ? $this->mediaService->createMedia($video) : null;
        $payload['image'] = $image ? $this->mediaService->createMedia($image) : null;
        $exercise = $this->exerciseService->updateExercise($id, $payload);
        return $this->getResponse(new ExerciseResource($exercise), 'muscle updated');
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
            return $this->getResponse(null, 'muscle deleted', 204);
        } catch (\Throwable $th) {
            abort(400, 'delete exercise is error');
        }
    }
}
