<?php

namespace App\Models;

use App\Enums\Level;
use App\Enums\MediaType;
use App\Enums\TypeExercise;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $guarded = [];
    // protected $casts = [
    //     'type' => TypeExercise::class,
    //     'level' => Level::class,
    // ];

    //=========== convert attribute ============
    //==========================================
    public function level(): Attribute
    {
        return Attribute::make(
            set: fn ($name) => Level::fromName($name),
            get: fn ($value) => Level::fromValue($value)
        );
    }

    public function type(): Attribute
    {
        return Attribute::make(
            set: fn ($name) => TypeExercise::fromName($name),
            get: fn ($value) => TypeExercise::fromValue($value),
        );
    }
    //=========== create relationship ==========
    //==========================================
    public function favourites()
    {
        return $this->morphMany(Favourite::class, 'favouriteable');
    }

    public function groupExercise()
    {
        return $this->belongsTo(GroupExercise::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function image()
    {
        return $this->morphOne(Media::class, 'mediable')->whereType(MediaType::image);
    }

    public function gif()
    {
        return $this->morphOne(Media::class, 'mediable')->whereType(MediaType::gif);
    }

    public function video()
    {
        return $this->morphOne(Media::class, 'mediable')->whereType(MediaType::video);
    }

    public function muscles()
    {
        return $this->belongsToMany(Muscle::class);
    }

    public function challenges()
    {
        return $this->belongsToMany(Challenge::class);
    }

    public function planItems()
    {
        return $this->belongsToMany(PlanItem::class);
    }
}
