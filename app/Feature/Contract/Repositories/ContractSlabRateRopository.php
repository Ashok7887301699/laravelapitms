<?php

namespace App\Feature\Contract\Repositories;

use App\Feature\Contract\Models\ContractSlabRate;

class ContractSlabRateRepository
{
    public function create(array $data)
    {
        return ContractSlabRate::create($data);
    }

    public function find($id)
    {
        return ContractSlabRate::find($id);
    }
}
