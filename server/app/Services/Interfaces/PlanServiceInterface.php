<?php

namespace App\Services\Interfaces;

interface PlanServiceInterface
{
    public function getAll();
    public function findById(int $id);
}
