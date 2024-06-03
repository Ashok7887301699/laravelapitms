<?php

namespace App\Feature\Vehicle\Repositories;

use App\Feature\Vehicle\Models\Vehicle;

class VehicleRepository
{
    public function create(array $data): Vehicle
    {
    // Create and return a new Tenant model
        return Vehicle::create($data);
    }

    public function find($SrNo)
    {
       return Vehicle::where('SrNo', $SrNo)->first();
    }

}
