<?php

namespace App\Feature\Vendor\Repositories;

use App\Feature\Vendor\Models\Vendor;

class VendorRepository
{
    public function create(array $data): Vendor
    {
        // Create and return a new Vendor model
        return Vendor::create($data);
    }

    public function find($id)
    {
        return Vendor::find($id);
    }

   
}
