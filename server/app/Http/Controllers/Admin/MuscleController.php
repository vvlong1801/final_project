<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MediaCollection;
use App\Http\Requests\Admin\StoreMuscleRequest;
use App\Services\Interfaces\MuscleServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\MuscleResource;
use App\Services\Interfaces\MediaServiceInterface;

class MuscleController extends Controller
{
    protected $muscleService;
    protected $mediaService;
    public function __construct(MuscleServiceInterface $muscleService, MediaServiceInterface $mediaService)
    {
        $this->muscleService = $muscleService;
        $this->mediaService = $mediaService;
    }

    public function index()
    {
        $muscles = $this->muscleService->getMuscles();
        return $this->responseOk(MuscleResource::collection($muscles), 'get muscles is success!');
    }

    public function create(StoreMuscleRequest $request)
    {
        $payload = $request->validated();
        $image = \Arr::get($payload, 'image');
        $icon = \Arr::get($payload, 'icon', false);

        try {
            $payload['image'] = $this->mediaService->createMedia($image, MediaCollection::Muscle);
            $payload['icon'] = $icon ? $this->mediaService->createMedia($icon, MediaCollection::Muscle) : null;
             $this->muscleService->createMuscle($payload);
            return $this->responseNoContent('create muscle is success!');
        } catch (\Throwable $th) {
            abort(404, $th->getMessage());
        }
    }

    public function update($id, StoreMuscleRequest $request)
    {
        $payload = $request->validated();
        $image = \Arr::get($payload, 'image');
        $icon = \Arr::get($payload, 'icon', false);
        try {
            $payload['image'] = $this->mediaService->updateMedia($image, MediaCollection::Muscle);
            $payload['icon'] = $icon ? $this->mediaService->updateMedia($icon, MediaCollection::Muscle) : null;

            $this->muscleService->updateMuscle($id, $payload);
            return $this->responseNoContent('update muscle is success!');
        } catch (\Throwable $th) {
            abort(400, $th->getMessage());
        }
    }

    public function delete($id)
    {
        $this->muscleService->deleteMuscle($id);

        return $this->responseNoContent('delete muscle is success!');
    }
}
