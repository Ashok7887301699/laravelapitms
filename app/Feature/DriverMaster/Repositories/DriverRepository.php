<?php

namespace App\Feature\DriverMaster\Repositories;

use App\Feature\DriverMaster\Models\Driver;

class DriverRepository
{
    public function create(array $data): Driver
    {
        return Driver::create($data);
    }

    public function find($id)
    {
        return Driver::find($id);
    }
}