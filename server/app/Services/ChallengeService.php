<?php

namespace App\Services;

use App\Models\Challenge;
use App\Services\Interfaces\ChallengeServiceInterface;

class ChallengeService extends BaseService implements ChallengeServiceInterface
{
    public function getAll()
    {
        return Challenge::all();
    }

    public function findById(int $id)
    {
        $challenge = Challenge::whereId($id)->first();
        return $challenge;
    }

    public function create(Challenge $challenge, array $exercises)
    {
        dd($exercises);
        $challenge->save();
        $challenge->exercises()->attach($exercises);
    }
}
