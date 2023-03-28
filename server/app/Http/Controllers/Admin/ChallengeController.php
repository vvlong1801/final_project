<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreChallengeResquest;
use App\Http\Resources\ChallengeResource;
use App\Http\Resources\ChallengeTypeResource;
use App\Models\ChallengeType;
use App\Services\Interfaces\ChallengeServiceInterface;
use App\Services\Interfaces\MediaServiceInterface;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    protected $challengeService;
    protected $mediaService;
    public function __construct(ChallengeServiceInterface $challengeService, MediaServiceInterface $mediaService)
    {
        $this->challengeService = $challengeService;
        $this->mediaService = $mediaService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $challenges = $this->challengeService->getChallenges();
        return $this->getResponse(ChallengeResource::collection($challenges), 'get challenges is success');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(StoreChallengeResquest $request)
    {
        $payload = $request->validated();
        $image = \Arr::get($payload, 'image', false);
        $payload['image'] = $image ? $this->mediaService->createMedia($image) : null;
        $challenge = $this->challengeService->createChallenge($payload);

        return $this->getResponse(new ChallengeResource($challenge), 'challenge created');
    }

    /**
     * Display the specified resource.
     */
    public function findById($id)
    {
        $challenge = $this->challengeService->getChallengeById($id);
        return $this->getResponse(new ChallengeResource($challenge), 'get challenge is success');
    }

    public function getChallengeTypes()
    {
        $challengeTypes = $this->challengeService->getChallengeTypes();
        return $this->getResponse(ChallengeTypeResource::collection($challengeTypes), 'get challenge types success');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, StoreChallengeResquest $request)
    {
        $payload = $request->validated();
        $image = \Arr::get($payload, 'image', false);
        $payload['image'] = $image ? $this->mediaService->createMedia($image) : null;
        $challenge = $this->challengeService->updateChallenge($id, $payload);

        return $this->getResponse(new ChallengeResource($challenge), 'challenge updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $result = $this->challengeService->deleteChallenge($id);
        return $this->getResponse($result, 'challenge deleted');
    }
}
