<?php

namespace App\Feature\Contract\Repositories;

use App\Feature\Contract\Models\ContractSlabDefinition;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class slab_definitions_repository
{
    // public function create($data)
    // {
    //     $existingRecord = ContractSlabDefinition::where('contract_id', $data['contract_id'])
    //         ->where('slab_number', $data['slab_number'])
    //         ->first();

    //     if ($existingRecord) {
    //         return ['error' => 'Record already exists'];
    //     }

    //     // If the record does not exist, create a new one
    //     return ContractSlabDefinition::create($data);
    // }
    public function create($data)
{
    // Assuming $data contains the fields 'contract_id', 'slab_number', 'slab_lower_limit', 'slab_upper_limit', 'slab_rate_type'
    
    // Insert a new record without checking for existing records
    return ContractSlabDefinition::create($data);
}

    public function getAll()
    {
        return ContractSlabDefinition::all();
    }
    public function getslabbyid($id)
    {
        try {
            return ContractSlabDefinition::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return null;
        }
    }
}
