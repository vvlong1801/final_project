<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEquipmentRequest;
use App\Http\Resources\EquipmentResource;
use App\Services\Interfaces\EquipmentServiceInterface;


class EquipmentController extends Controller
{
    protected $equipmentService;
    public function __construct(EquipmentServiceInterface $equipmentService)
    {
        $this->equipmentService = $equipmentService;
    }

    public function index()
    {
        $equipments = $this->equipmentService->getEquipments();
        return $this->getResponse(EquipmentResource::collection($equipments), 'get equipments is success!');
    }

    public function create(StoreEquipmentRequest $request)
    {
        $payload = $request->validated();
        $equipment = $this->equipmentService->createEquipment($payload);

        return $this->getResponse(new EquipmentResource($equipment), 'create equipment is success!');
    }

    public function update($id, StoreEquipmentRequest $request)
    {
        $payload = $request->validated();
        $muscle = $this->equipmentService->updateEquipment($id, $payload);
        return $this->getResponse($muscle, 'update muscle is success!');
    }

    public function delete($id)
    {
        $this->equipmentService->deleteEquipment($id);

        return $this->getResponse(null, 'delete muscle is success!');
    }
}
