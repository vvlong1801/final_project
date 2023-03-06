<?php

namespace App\Http\Resources;

use App\Services\Interfaces\StorageServiceInterface;
use App\Supports\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MuscleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $storageService = app()->make(StorageServiceInterface::class);
        $iconUrl = $storageService->getTemporaryUrl($this->icon);
        $imageUrl = $storageService->getTemporaryUrl($this->image);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'icon' => $iconUrl,
            'image' => $imageUrl,
            'description' => $this->description,
        ];
    }
}
