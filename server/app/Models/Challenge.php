<?php

namespace App\Models;

use App\Enums\CommonStatus;
use FFI;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $guarded = [];

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

    // =============== relationship =================
    // ==============================================
    public function phases()
    {
        return $this->hasMany(ChallengePhase::class);
    }

    public function image()
    {
        return $this->morphOne(Media::class, 'mediable');
    }
}
