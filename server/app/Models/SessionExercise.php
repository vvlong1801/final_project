<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SessionExercise extends Pivot
{
    protected $with = ['requirements'];
    public function requirements()
    {
        return $this->hasMany(ExerciseRequirement::class);
    }
}
