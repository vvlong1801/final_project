<?php

namespace App\Services;

use App\Models\Challenge;
use App\Services\Interfaces\ChallengeServiceInterface;

class ChallengeService extends BaseService implements ChallengeServiceInterface
{
    public function getChallenges()
    {
        return Challenge::with(['type', 'image'])->withCount('exercises')->get();
    }

    public function getChallengeById($id)
    {
        $challenge = Challenge::with(['type', 'image'])->withCount('exercises')->whereId($id)->first();
        return $challenge;
    }

    public function createChallenge(array $payload)
    {
        $challenge = new Challenge(\Arr::only($payload, ['name', 'description']));
        $challenge->save();
        $challenge->image()->save($payload['image']);
        $challenge->exercises()->attach($payload['exercises']);

        return $challenge->loadCount('exercises');
    }

    public function updateChallenge($id, array $payload)
    {
        $challenge = Challenge::find($id);
        $payload['type_id'] = \Arr::get($payload, 'type', 0);
        $challenge->update(\Arr::only($payload, ['name', 'type_id', 'description']));

        if ($payload['image']) $challenge->image()->update($payload['image']->getAttributes());
        $challenge->exercises()->sync(\Arr::get($payload, 'exercises', []));

        return $challenge->loadCount('exercises');
    }

    public function deleteChallenge($id)
    {
        $result = Challenge::where('id', $id)->delete();
        if (!$result) throw new \Exception("delete is error");
    }
}
