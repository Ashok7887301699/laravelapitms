<?php

namespace App\Feature\User\Repositories;

use App\Feature\User\Models\RolePrivilege;

class RolePrivilegeRepository
{
    public function create(array $data): RolePrivilege
    {
        $data['status'] = $data['status'] ?? 'ACTIVE';
        // Create and return a new RolePrivilege model
        return RolePrivilege::create($data);
    }

    public function find(array $compositeKey)
    {
        // Assuming $compositeKey is an array with ['role_id', 'privilege_id']
        return RolePrivilege::where('role_id', $compositeKey[0])
                            ->where('privilege_id', $compositeKey[1])
                            ->first();
    }

   
}
