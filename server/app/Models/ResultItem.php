<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultItem extends Model
{
    use HasFactory;

    public function planItemExercise()
    {
        return $this->belongsTo(PlanItemExercise::class);
    }

    public function result()
    {
        return $this->belongsTo(Result::class);
    }
}
