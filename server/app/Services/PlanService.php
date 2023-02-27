<?php

namespace App\Services;

use App\Models\Plan;
use App\Services\Interfaces\PlanServiceInterface;
use Illuminate\Support\Facades\Auth;

class PlanService extends BaseService implements PlanServiceInterface
{
    public function getAll()
    {
        // dd(Auth::user()->member->id);
        $plans = Plan::whereMemberId(Auth::user()->member->id)->get();
        return $plans;
    }

    public function findById(int $id)
    {
        $plan = Plan::whereMemberId(Auth::user()->member->id)->whereId($id)->get();
        return $plan;
    }
}
