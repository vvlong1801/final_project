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
            "created_by" =>  $this->createdBy->name,
            "groups" => TagResource::collection($this->groupTags),

            "evaluate_method" => $this->evaluate_method,
            "equipment" => new EquipmentResource(
                $this->whenLoaded('equipment')
            ),
            "muscles" => MuscleResource::collection(
                $this->whenLoaded('muscles')
            ),
            "description" => $this->description,
            "gif" => new MediaResource(
                $this->whenLoaded('gif')
            ),
            "image" => new MediaResource(
                $this->whenLoaded('image')
            ),
            "video" => new MediaResource(
                $this->whenLoaded('video')
            ),

        ];
    }
}
