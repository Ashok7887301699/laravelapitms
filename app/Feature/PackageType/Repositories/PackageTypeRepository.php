<?php

namespace App\Feature\PackageType\Repositories;

use App\Feature\PackageType\Models\PackageType;

class PackageTypeRepository
{
    public function create(array $data): PackageType
    {
        // Create and return a new PackageType model
        return PackageType::create($data);
    }

    public function find($id)
    {
        return PackageType::find($id);
    }

    public function all(){
        return PackageType::all();
    }
}