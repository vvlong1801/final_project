<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengeType extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function challenges()
    {
        $this->hasMany(Challenge::class);
    }
}
