<?php

namespace App\Feature\Contract\Repositories;

use App\Feature\Contract\Models\ContractExcessWeight;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class ExcessRepository
{
    public function create(array $dataArray): ContractExcessWeight
    {
        // Create and return a new ContractExcessWeight model
        return ContractExcessWeight::create($dataArray);
    }
    public function getAllExcessweight()
    {
        // Retrieve all ContractServices
        return ContractExcessWeight::all();
    }
    public function findexcess($contract_id)
    {        try {
        return  ContractExcessWeight::where('contract_id', $contract_id)->firstOrFail();
    } catch (ModelNotFoundException $exception) {
        return null;
    }

    }
}
