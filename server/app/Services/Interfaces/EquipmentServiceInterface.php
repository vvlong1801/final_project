<?php

namespace App\Services\Interfaces;

use App\Models\Challenge;
use App\Models\Equipment;

interface EquipmentServiceInterface
{
    public function getEquipments();
    public function getEquipmentsWithPagination();
    // public function findById(int $id);
    public function createEquipment(array $payload);
    public function updateEquipment($id, array $payload);
    public function deleteEquipment($id);
}
