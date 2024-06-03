<?php

namespace App\Feature\VendorFuel\Repositories;

use App\Feature\VendorFuel\Models\VendorFuel;

class VendorFuelRepository
{
    public function create(array $data): VendorFuel
    {
        // Create and return a new VendorFuel model
        return VendorFuel::create($data);
    }

    public function find($id)
    {
        return VendorFuel::find($id);
    }

   
}
