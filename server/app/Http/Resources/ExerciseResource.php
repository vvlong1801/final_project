<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExerciseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "level" => $this->level,
            "type" => $this->type,
            "equipment" => new EquipmentResource($this->equipment),
            "muscles" => MuscleResource::collection($this->muscles),
            "description" => $this->description,
            "gif" => new MediaResource($this->gif),
            "image" => new MediaResource($this->image),
            "video" => new MediaResource($this->video),
        ];
    }
}
