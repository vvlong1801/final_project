<?php

namespace App\Models;

use App\Enums\MediaType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }

    public function image()
    {
        return $this->morphOne(Media::class, 'mediable')->whereType(MediaType::image);
    }


    public function icon()
    {
        return $this->morphOne(Media::class, 'mediable')->whereType(MediaType::icon);
    }
}
