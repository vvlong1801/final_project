<?php

namespace App\Models;

use App\Enums\EvaluateMethod;
use App\Enums\Level;
use App\Enums\MediaType;
use App\Enums\Role;
use App\Supports\Helper;
use Exception;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $guarded = [];
    //=========== convert attribute ============
    //==========================================
    public function level(): Attribute
    {
        return Attribute::make(
            set: fn ($name) => Level::fromName($name),
            get: fn ($value) => Level::fromValue($value)
        );
    }

    public function evaluateMethod(): Attribute
    {
        return Attribute::make(
            set: fn ($name) => EvaluateMethod::fromName($name),
            get: fn ($value) => EvaluateMethod::fromValue($value),
        );
    }
    //=========== create relationship ==========
    //==========================================

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

    public function groupExercises()
    {
        return $this->belongsToMany(GroupExercise::class);
    }

    public function createdBy()
    {
        $user =  $this->belongsTo(User::class, 'created_by');

        if ($user->first()->belongsRoles([Role::admin, Role::creator, Role::superAdmin])) {
            return $user;
        } else {
            throw new Exception("user created this exercise who isn't creator", 1);
        }
    }

    public function sessionExercises()
    {
        return $this->hasMany(SessionExercise::class);
    }
}
