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
        $equipment = Equipment::create(\Arr::only($payload, ['name', 'description']));

        $equipment->image()->save($payload['image']);

        if ($payload['icon']) {
            $equipment->icon()->save($payload['icon']);
        }
        return $equipment;
    }

    public function updateEquipment($id, array $payload)
    {
        $equipment = Equipment::find($id);
        $equipment->name = \Arr::get($payload, 'name', '');
        $equipment->description = \Arr::get($payload, 'description', '');
        $equipment->save();
        if ($image = \Arr::get($payload, 'image', false)) {
            $equipment->image()->update($image->getAttributes());
        }
        if ($icon = \Arr::get($payload, 'icon', false)) {
            $equipment->icon()->update($icon->getAttributes());
        }

        return $equipment;
    }

    public function deleteEquipment($id)
    {
        Equipment::destroy($id);
    }
}
