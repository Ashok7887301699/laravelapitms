<?php

namespace App\Feature\GroupMaster\Repositories;

use App\Feature\GroupMaster\Models\GroupMaster;

class GroupMasterRepository
{
    public function create(array $data): GroupMaster
    {
        // Create and return a new VendorFuel model
        return GroupMaster::create($data);
    }

    public function find($id)
    {
        return GroupMaster::find($id);
    }

   
}
