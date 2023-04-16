<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutSession extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function challengePhase()
    {
        return $this->belongsTo(ChallengePhase::class);
    }

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class)->orderByPivot('order');
    }
}
