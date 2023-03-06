<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreMuscleRequest;
use App\Services\Interfaces\MuscleServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\MuscleResource;

class MuscleController extends Controller
{
    protected $muscleService;
    public function __construct(MuscleServiceInterface $muscleService)
    {
        $this->muscleService = $muscleService;
    }

    public function index()
    {
        $muscles = $this->muscleService->getMuscles();
        return $this->getResponse(MuscleResource::collection($muscles), 'get muscles is success!');
    }

    public function create(StoreMuscleRequest $request)
    {
        $payload = $request->validated();
        $muscle = $this->muscleService->createMuscle($payload);

        return $this->getResponse(new MuscleResource($muscle), 'create muscle is success!');
    }

    public function update($id, StoreMuscleRequest $request)
    {
        $payload = $request->validated();
        $muscle = $this->muscleService->updateMuscle($id, $payload);
        return $this->getResponse($muscle, 'update muscle is success!');
    }
    
    public function delete($id)
    {
        $this->muscleService->deleteMuscle($id);

        return $this->getResponse(null, 'delete muscle is success!');
    }
}
