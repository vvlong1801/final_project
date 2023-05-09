<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MediaCollection;
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
        return $this->responseOk(EquipmentResource::collection($equipments), 'get equipments is success!');
    }

    public function create(StoreEquipmentRequest $request)
    {
        $payload = $request->validated();
        $icon = \Arr::get($payload, 'icon', false);
        try {
            $payload['image'] = $this->mediaService->createMedia($payload['image'], MediaCollection::Equipment);
            $payload['icon'] = $icon ? $this->mediaService->createMedia($icon, MediaCollection::Equipment) : null;
            $this->equipmentService->createEquipment($payload);
            return $this->responseNoContent('create equipment is success!');
        } catch (\Throwable $th) {
            abort(400, $th->getMessage());
        }
    }

    public function update($id, StoreEquipmentRequest $request)
    {
        $payload = $request->validated();
        $icon = \Arr::get($payload, 'icon', false);
        try {
            $payload['image'] = $this->mediaService->updateMedia($payload['image'], MediaCollection::Equipment);
            $payload['icon'] = $icon ? $this->mediaService->updateMedia($icon, MediaCollection::Equipment) : null;
            $this->equipmentService->updateEquipment($id, $payload);
            return $this->responseNoContent('update equipment is success!');
        } catch (\Throwable $th) {
            abort(400, $th->getMessage());
        }
    }

    public function delete($id)
    {
        $this->equipmentService->deleteEquipment($id);

        return $this->responseNoContent('delete equipment is success!');
    }
}
