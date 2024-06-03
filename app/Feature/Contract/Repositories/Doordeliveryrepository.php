<?php

namespace App\Feature\Contract\Repositories;

use App\Feature\Contract\Models\contract_door_deliverie;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Doordeliveryrepository
{
    public function create(array $data): contract_door_deliverie
    {
        return contract_door_deliverie::create($data);
    }

    public function getAll()
    {
        try {
            // Retrieve all ContractServices
            return contract_door_deliverie::all();
        } catch (\Exception $e) {
            // Handle any exceptions here
            // Log the error or return appropriate response
            return [];
        }
    }

    public function findrates($contract_id)
    {
        try {
            return contract_door_deliverie::where('contract_id', $contract_id)->get();
        } catch (\Exception $e) {
            // Handle any exceptions here
            // Log the error or return appropriate response
            return null;
        }
    }
    
    public function update(array $data, $contract_id): contract_door_deliverie
    {
        // Find the entry by contract ID
        $contract =  contract_door_deliverie::where('contract_id', $contract_id)->firstOrFail();
        // Update the entry with the provided data
        $contract->update($data);
        
        return $contract;
    }
}
