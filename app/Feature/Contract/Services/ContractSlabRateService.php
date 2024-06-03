<?php

namespace App\Feature\Contract\Services;

use App\Feature\Contract\Models\ContractSlabRate;
use Illuminate\Support\Facades\Log;

class ContractSlabRateService
{
    public function createContractSlabRate(array $data)
    {
        Log::info('Creating ContractSlabRate in ContractSlabRateService');
        return ContractSlabRate::create($data);
    }

    public function getContractSlabRateById($id)
    {
        Log::info('Fetching ContractSlabRate by ID in ContractSlabRateService');
        return ContractSlabRate::findOrFail($id);
    }

    public function getAllContractSlabRates($request)
    {
        Log::info('Fetching all ContractSlabRates in ContractSlabRateService');
        return ContractSlabRate::all();
    }

    public function updateContractSlabRate($id, array $data)
    {
        Log::info('Updating ContractSlabRate in ContractSlabRateService');
        $contractSlabRate = ContractSlabRate::findOrFail($id);
        $contractSlabRate->update($data);

        return $contractSlabRate;
    }


    public function deleteContractSlabRate($id)
    {
        Log::info('Deleting ContractSlabRate in ContractSlabRateService');
        $contractSlabRate = ContractSlabRate::findOrFail($id);

        return $contractSlabRate->delete();
    }
}
