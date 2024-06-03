<?php

namespace App\Feature\Hamali\Repositories;

use App\Feature\Hamali\Models\Hamali;

class HamaliRepository
{
    public function create(array $data): Hamali
    {
        // Create and return a new Hamali model
        return Hamali::create($data);
    }

    public function find($id)
    {
        return Hamali::find($id);
    }

   
}
