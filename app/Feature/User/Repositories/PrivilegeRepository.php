<?php

namespace App\Feature\User\Repositories;

use App\Feature\User\Models\Privilege;

class PrivilegeRepository
{
    public function create(array $data): Privilege
    {
        // Create and return a new Privilege model
        return Privilege::create($data);
    }

    public function find($id)
    {
        return Privilege::find($id);
    }

   
}
