<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function music()
    {
        return $this->belongsTo(Music::class);
    }

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public function favouriteExercises()
    {
        return $this->belongsToMany(Exercise::class, 'favourites');
    }

    public function favouritePlanItems()
    {
        return $this->belongsToMany(PlanItem::class, 'favourites');
    }
}
