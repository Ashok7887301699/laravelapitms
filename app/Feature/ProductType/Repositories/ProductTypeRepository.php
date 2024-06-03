<?php

namespace App\Feature\ProductType\Repositories;

use App\Feature\ProductType\Models\ProductType;

class ProductTypeRepository
{
    public function create(array $data): ProductType
    {
        // Create and return a new Tenant model
        return ProductType::create($data);
    }


    public function find($id)
    {
        return ProductType::find($id);
    }

}
