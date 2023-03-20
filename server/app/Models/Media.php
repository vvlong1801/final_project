<?php

namespace App\Models;

use App\Enums\CommonStatus;
use App\Enums\MediaType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'type' => MediaType::class,
        'status' => CommonStatus::class,
    ];

    public function mediable()
    {
        return $this->morphTo();
    }
}
