<?php

namespace App\Feature\ContractPaymentType\Repositories;

use App\Feature\ContractPaymentType\Models\ContractPaymentType;

class ContractPaymentTypeRepository
{
    public function create(array $data): ContractPaymentType
    {
        // Create and return a new ContractPaymentType model
        return ContractPaymentType::create($data);
    }

    public function find($id)
    {
        return ContractPaymentType::find($id);
    }

    
}
