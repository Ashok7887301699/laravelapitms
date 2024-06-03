<?php

namespace App\Feature\VehicleCapacityModel\Repositories;

use App\Feature\VehicleCapacityModel\Models\VehicleCapacityModel;

class VehicleCapacityModelRepository
{
    public function create(array $data): VehicleCapacityModel
    {
        // Create and return a new VendorFuel model
        return VehicleCapacityModel::create($data);
    }

    public function find($id)
    {
        return VehicleCapacityModel::find($id);
    }

   
}
