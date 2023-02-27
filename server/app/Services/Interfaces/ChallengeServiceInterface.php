<?php

namespace App\Services\Interfaces;

use App\Models\Challenge;

interface ChallengeServiceInterface
{
    public function getAll();
    public function findById(int $id);
    public function create(Challenge $challenge, array $exercises);
}
