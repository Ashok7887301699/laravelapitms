<?php

namespace App\Feature\Contract\Repositories;

use App\Feature\Contract\Models\ContractServices;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ServiceRepository
{
    public function create(array $data): ?ContractServices
    {
        // Check if a service with the same contract_id already exists
        $existingService = ContractServices::where('contract_id', $data['contract_id'])->first();
        
        if ($existingService) {
            // If a service with the same contract_id exists, return null
            echo "Already exit";
            return null;
        }

        // Create and return a new ContractService model
        return ContractServices::create($data);
    }

    public function getAll()
    {
        // Retrieve all ContractServices
        return ContractServices::all();
    }

    public function find($contract_id)
    {
        try {
            
            return ContractServices::where('contract_id', $contract_id)->firstOrFail();;
        } catch (ModelNotFoundException $exception) {
            return null;
        }
    }
}
