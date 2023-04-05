<?php

namespace App\Http\Resources;

use App\Http\Resources\Collections\ExerciseCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupExerciseResource extends JsonResource
{
    protected $simple;
    public function __construct($resource, bool $typeSimple)
    {
        parent::__construct($resource);
        $this->simple = $typeSimple;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->simple) {
            return [
                'id' => $this->id,
                'name' => $this->name,
            ];
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'exercises' => ExerciseResource::collection($this->exercises),
        ];
    }
}
