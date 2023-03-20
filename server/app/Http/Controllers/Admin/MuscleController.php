<?php

namespace App\Http\Controllers\Admin;

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
        return $this->getResponse(MuscleResource::collection($muscles), 'get muscles is success!');
    }

    public function create(StoreMuscleRequest $request)
    {
        $payload = $request->validated();
        $image = \Arr::get($payload, 'image', false);
        $icon = \Arr::get($payload, 'icon', false);

        $payload['image'] = $image ? $this->mediaService->createMedia($image) : null;
        $payload['icon'] = $icon ? $this->mediaService->createMedia($icon) : null;

        if ($payload['image'] !== null) {
            $muscle = $this->muscleService->createMuscle($payload);
            return $this->getResponse(new MuscleResource($muscle), 'create muscle is success!');
        } else {
            return $this->getResponse([
                'error' => [
                    'code' => 422,
                    'message' => 'cannot find the image file in server'
                ]
            ], 422);
        }
    }

    public function update($id, StoreMuscleRequest $request)
    {
        $payload = $request->validated();
        $image = \Arr::get($payload, 'image', false);
        $icon = \Arr::get($payload, 'icon', false);
        $payload['image'] = $image ? $this->mediaService->createMedia($image) : null;
        $payload['icon'] = $icon ? $this->mediaService->createMedia($icon) : null;

        $muscle = $this->muscleService->updateMuscle($id, $payload);
        return $this->getResponse(new MuscleResource($muscle), 'update muscle is success!');
    }

    public function delete($id)
    {
        $this->muscleService->deleteMuscle($id);

        return $this->getResponse(null, 'delete muscle is success!');
    }
}
