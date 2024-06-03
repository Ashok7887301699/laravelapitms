<?php

namespace App\Feature\User\Repositories;

use App\Feature\User\Models\Role;

class RoleRepository
{
    public function create(array $data): Role
    {
        // Create and return a new Role model
        return Role::create($data);
    }

    public function find($id)
    {
        return Role::find($id);
    }

   
}
