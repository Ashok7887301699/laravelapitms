<?php

namespace App\Feature\India\Repositories;

use App\Feature\India\Models\India;

class IndiaRepository
{
    public function create(array $data): India
    {
        // Create and return a new India model
        return India::create($data);
    }

    public function find($id)
    {
        return India::find($id);
    }
}
