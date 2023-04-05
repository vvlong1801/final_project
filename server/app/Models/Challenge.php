<?php

namespace App\Models;

use App\Enums\CommonStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $guarded = [];

    // protected $casts = [
    //     'status' => CommonStatus::class,
    // ];

    // public function getStatusAttribute($value)
    // {
    //     return CommonStatus::fromValue($value);
    // }
    protected function status(): Attribute
    {
        return Attribute::make(
            set: fn ($name) => CommonStatus::fromName($name),
            get: fn ($value) => CommonStatus::fromValue($value),
        );
    }
    // public function status(): Attribute
    // {
    //     return Attribute::make(get: fn ($value) => CommonStatus::fromValue($value));
    // }

    // public function numberOfExercises(): Attribute
    // {
    //     return Attribute::make(get: fn ($value, $attributes) => );
    // }

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class);
    }

    public function image()
    {
        return $this->morphOne(Media::class, 'mediable');
    }
}
