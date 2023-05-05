<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreChallengeRequest;
use App\Http\Resources\ChallengeResource;

use App\Services\Interfaces\ChallengeServiceInterface;
use App\Services\Interfaces\MediaServiceInterface;


class ChallengeController extends Controller
{
    protected $challengeService;

    public function __construct(ChallengeServiceInterface $challengeService)
    {
        $this->challengeService = $challengeService;
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
    public function create(StoreChallengeRequest $request, MediaServiceInterface $mediaService)
    {
        $payload = $request->validated();
        $image = \Arr::get($payload, 'image', null);
        $payload['image'] = $mediaService->createMedia($image);
        $payload['created_by'] = $request->user()->id;
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


    /**
     * Update the specified resource in storage.
     */
    public function update($id, StoreChallengeRequest $request,  MediaServiceInterface $mediaService)
    {
        $payload = $request->validated();
        $image = \Arr::get($payload, 'image', false);
        $payload['image'] = $image ? $mediaService->createMedia($image) : null;
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
