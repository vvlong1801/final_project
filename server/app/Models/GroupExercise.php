<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupExercise extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function image()
    {
        return $this->morphOne(Media::class, 'mediable');
    }

    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }
}
