<?php

namespace App\Feature\IndustryType\Repositories;

use App\Feature\IndustryType\Models\IndustryType;

class IndustryTypeRepository
{
    public function create(array $data): IndustryType
    {
        // Create and return a new IndustryType model
        return IndustryType::create($data);
    }

    public function find($id)
    {
        return IndustryType::find($id);
    }

    public function all(){
        return IndustryType::all();
    }
}