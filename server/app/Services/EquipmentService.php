<?php

namespace App\Services;

use App\Models\Equipment;
use App\Services\Interfaces\EquipmentServiceInterface;

class EquipmentService extends BaseService implements EquipmentServiceInterface
{
    public function getEquipments()
    {
        return Equipment::all();
    }

    public function getEquipmentsWithPagination()
    {
        return  Equipment::paginate(12);
    }

    public function createEquipment(array $payload)
    {
        return Equipment::create($payload);
    }

    public function updateEquipment($id, array $payload)
    {
        return Equipment::where('id', $id)->update($payload);
    }

    public function deleteEquipment($id)
    {
        Equipment::destroy($id);
    }
}
