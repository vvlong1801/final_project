<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEquipmentRequest;
use App\Http\Resources\EquipmentResource;
use App\Services\Interfaces\EquipmentServiceInterface;
use App\Services\Interfaces\MediaServiceInterface;

class EquipmentController extends Controller
{
    protected $equipmentService;
    protected $mediaService;
    public function __construct(EquipmentServiceInterface $equipmentService, MediaServiceInterface $mediaService)
    {
        $this->equipmentService = $equipmentService;
        $this->mediaService = $mediaService;
    }

    public function index()
    {
        $equipments = $this->equipmentService->getEquipments();
        return $this->getResponse(EquipmentResource::collection($equipments), 'get equipments is success!');
    }

    public function create(StoreEquipmentRequest $request)
    {
        $payload = $request->validated();
        $image = \Arr::get($payload, 'image', false);
        $icon = \Arr::get($payload, 'icon', false);

        $payload['image'] = $image ? $this->mediaService->createMedia($image) : null;
        $payload['icon'] = $icon ? $this->mediaService->createMedia($icon) : null;

        if ($payload['image'] !== null) {
            $equipment = $this->equipmentService->createEquipment($payload);
            return $this->getResponse(new EquipmentResource($equipment), 'create equipment is success!');
        } else {
            abort(422, 'image not found');
        }
    }

    public function update($id, StoreEquipmentRequest $request)
    {
        $payload = $request->validated();
        $image = \Arr::get($payload, 'image', false);
        $icon = \Arr::get($payload, 'icon', false);
        $payload['image'] = $image ? $this->mediaService->createMedia($image) : null;
        $payload['icon'] = $icon ? $this->mediaService->createMedia($icon) : null;

        $equipment = $this->equipmentService->updateEquipment($id, $payload);
        return $this->getResponse(new EquipmentResource($equipment), 'update equipment is success!');    }

    public function delete($id)
    {
        $this->equipmentService->deleteEquipment($id);

        return $this->getResponse(null, 'delete equipment is success!');
    }
}
