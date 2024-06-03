<?php

namespace App\Feature\Contract\Services;

use App\Feature\Contract\Repositories\ContractRepository;
use App\Feature\Contract\Models\Contract;
use App\Feature\Contract\Models\Customer;
use Illuminate\Support\Facades\Log;

class ContractService
{
    protected $contractRepository;

    public function __construct(ContractRepository $contractRepository)
    {
        $this->contractRepository = $contractRepository;
    }

    public function createContract(array $data)
    {
        try {
            // Additional ServiceRepository logic before saving can go here
            return $this->contractRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error creating contract: ' . $e->getMessage());
            throw $e; // Re-throw the exception for handling at a higher level
        }
    }

    public function getContractById($contract_id)
    {
        Log::info('Fetching Contract by ID in ContractService');
        // Assuming Contract and Customer models are properly imported at the top of your file
        $contract = Contract::query()
            ->join('customers', 'contracts.sap_cust_code', '=', 'customers.sap_cust_code')
            ->select('contracts.*', 'customers.CustName', 'customers.Category')
            ->where('contracts.contract_id', $contract_id)
            ->first(); // Retrieve the first matching contract or null
    
        return $contract;
    }
    

    public function getAllContracts($request)
    {
        Log::info('Fetching all Contracts in ContractService');
    
        $query = Contract::query()
                        ->join('customers', 'contracts.sap_cust_code', '=', 'customers.sap_cust_code')
                        ->select('contracts.*', 'customers.CustName', 'customers.Category');
    
        // Filter by 'customer_id'
        if ($request->has('contract_id')) {
            $query->where('contracts.contract_id', $request->contract_id);
        }
        if ($request->has('status')) {
            $query->where('contracts.status', $request->status);
        }
        // Filter by 'CustName'
        if ($request->has('CustName')) {
            $query->where('customers.CustName', 'like', '%'.$request->CustName.'%');
        }
    
        // Filter by 'created_at' date range
        if ($request->has(['created_from', 'created_to'])) {
            $query->whereBetween('created_at', [$request->created_from, $request->created_to]);
        }

        // Filter by 'updated_at' date range
        if ($request->has(['updated_from', 'updated_to'])) {
            $query->whereBetween('updated_at', [$request->updated_from, $request->updated_to]);
        }
    
        // Sorting
        $query->orderBy($request->get('sort_by', 'updated_at'), $request->get('sort_order', 'desc'));
    
        // Pagination
        $perPage = $request->get('per_page', 10); // Default to 10 if not provided
    
        return $query->paginate($perPage);
    }
    

    public function updateContract($selectedContractId, array $data)
    {
        Log::info('Updating Contract in ContractService');
    
        // Find the contract based on the contract_id column
        $contract = Contract::where('contract_id', $selectedContractId)->firstOrFail();
        
        // Update the contract with the provided data
        $contract->update($data);
    
        return $contract;
    }
    

    public function deactivateContract($contract_id)
    {
        Log::info('Deactivating Contract in ContractService');
        
        $contract = Contract::where('contract_id', $contract_id)->firstOrFail();
        $contract->update(['status' => 'INACTIVE']); // Update the status to 'INACTIVE'
        
        // Optionally, you can return the updated contract
        return $contract;
    }
    

    public function deleteContract($id)
    {
        Log::info('Deleting Contract in ContractService');
        $contract = Contract::findOrFail($id);

        return $contract->delete();
    }
    public function getcustbyname($query)
    {
        Log::info('Fetching Customer by name in ContractService');
        return Customer::where('CustName', 'like', '%' . $query . '%')
                       ->orWhere('sap_cust_code', 'like', '%' . $query . '%')
                       ->select('CustName', 'sap_cust_code','Category')
                       ->get();
    }
    public function getdatacust($data)
    {
        Log::info('Fetching Customer by name in ContractService');
        return Customer::where('sap_cust_code', $data)
                       ->select('Category')
                       ->get();
    }
    
    
}
