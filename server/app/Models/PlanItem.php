<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanItem extends Model
{
    use HasFactory;

    public function favourites()
    {
        return $this->morphMany(Favourite::class, 'favouriteable');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'plan_item_exercises')->withPivot(['rep', 'set', 'min_time', 'max_time']);
    }
}
