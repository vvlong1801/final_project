<?php

namespace App\Http\Resources\Collections;

use App\Http\Resources\Collections\Traits\PaginatesResourceCollection;
use App\Http\Resources\ExerciseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ExerciseCollection extends ResourceCollection
{
    use PaginatesResourceCollection;
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */

    public function toArray(Request $request): array
    {
        return [
            'data' => ExerciseResource::collection($this->collection),
            'pagination' => $this->getPaginates(),
        ];
    }
}
