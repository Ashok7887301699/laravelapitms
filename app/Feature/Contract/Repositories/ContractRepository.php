<?php

namespace App\Feature\Contract\Repositories;

use App\Feature\Contract\Models\Contract;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
class ContractRepository
{
    public function create(array $data)
    {
        try {
            // Check if a contract with the provided sap_cust_code already exists
            $existingContract = Contract::where('sap_cust_code', $data['sap_cust_code'])
                ->orWhere(function ($query) use ($data) {
                    // Check if start_date is between start_date and end_date of any existing contract
                    $startDate = new Carbon($data['start_date']);
                    $endDate = new Carbon($data['end_date']);
    
                    $query->where('status', 'ACTIVE')
                        ->where(function ($innerQuery) use ($startDate, $endDate) {
                            $innerQuery->whereBetween('start_date', [$startDate, $endDate])
                                ->orWhereBetween('end_date', [$startDate, $endDate]);
                        });
                })
                ->first();
    
            if ($existingContract) {
                // Handle case where a contract with the sap_cust_code already exists or start_date conflicts
                throw new \Exception('A contract with the provided Customer id already exists or the start date conflicts with an existing active contract.');
            }
    
            // If no existing contract found and no conflicts, proceed with creating the new contract
            return Contract::create($data);
        } catch (\Exception $e) {
            Log::error('Error creating contract: ' . $e->getMessage());
            throw $e; // Re-throw the exception for handling at a higher level
        }
    }
    


    public function find($id)
    {
        return Contract::find($id);
    }
}
