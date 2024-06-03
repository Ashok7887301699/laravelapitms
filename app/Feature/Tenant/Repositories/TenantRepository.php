<?php

namespace App\Feature\Tenant\Repositories;

use App\Feature\Tenant\Models\Tenant;

class TenantRepository
{
    public function create(array $data): Tenant
    {
        // Create and return a new Tenant model
        return Tenant::create($data);
    }

    public function find($id)
    {
        return Tenant::find($id);
    }
}
