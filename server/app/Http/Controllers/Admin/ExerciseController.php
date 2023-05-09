<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MediaCollection;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreExerciseRequest;
use App\Http\Resources\ExerciseResource;
use App\Services\Interfaces\ExerciseServiceInterface;
use App\Services\Interfaces\MediaServiceInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
            return $this->responseOk(ExerciseResource::collection($exercises), 'get exercises is success');
        } else {
            $exercises = $this->exerciseService->getExercises();
            return $this->responseOk(ExerciseResource::collection($exercises), 'get exercises is success');
        }
    }

    public function search(Request $payload)
    {
        $exercises = $this->exerciseService->getExercisesByFilters($payload->all(), auth()->id());
        return $this->responseOk(ExerciseResource::collection($exercises), 'success');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $exercise = $this->exerciseService->getExerciseById($id);
            $resource = new ExerciseResource($exercise);

            return $this->responseOk($resource, 'get exercises is success');
        } catch (\Throwable $th) {
            abort(404, 'not found data');
        }
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
            $payload['gif'] = $this->mediaService->createMedia($payload['gif'], MediaCollection::Exercise);
            $payload['image'] = $this->mediaService->createMedia($payload['image'], MediaCollection::Exercise);

            $video = \Arr::get($payload, 'video', false);
            if ($video) {
                $payload['video'] =  $this->mediaService->createMedia($video, MediaCollection::Exercise);
            }

            $this->exerciseService->createExercise($payload);
            return $this->responseNoContent('exercise created');
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
            $payload['gif'] = $this->mediaService->updateMedia($payload['gif'], MediaCollection::Exercise);
            $payload['image'] = $this->mediaService->updateMedia($payload['image'], MediaCollection::Exercise);

            $video = \Arr::get($payload, 'video', false);
            if ($video) {
                $payload['video'] =  $this->mediaService->updateMedia($video, MediaCollection::Exercise);
            }

            $this->exerciseService->updateExercise($id, $payload);
            return $this->responseNoContent('exercise updated');
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
    public function destroy(Request $request)
    {
        $ids = $request->validate(['*' => 'numeric']);
        $request->user()->can('bulkDelete', [Exercise::class, $ids]);
        try {
            $this->exerciseService->deleteExercise($ids);
            return $this->responseNoContent('exercise deleted');
        } catch (\Throwable $th) {
            abort(Response::HTTP_BAD_REQUEST, $th->getMessage());
        }
    }
}
