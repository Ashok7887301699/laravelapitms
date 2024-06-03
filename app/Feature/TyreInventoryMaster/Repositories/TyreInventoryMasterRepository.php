<?php

namespace App\Feature\TyreInventoryMaster\Repositories;

use App\Feature\TyreInventoryMaster\Models\TyreInventoryMaster;

class TyreInventoryMasterRepository
{
    public function create(array $data): TyreInventoryMaster
    {
        // Create and return a new TyreInventoryMaster model
        return TyreInventoryMaster::create($data);
    }

    public function find($id)
    {
        return TyreInventoryMaster::find($id);
    }

   
}
