<?php

namespace App\Feature\Contract\Controllers;

use App\Http\Controllers\Controller;
use App\Feature\Contract\Models\Contract;
use App\Feature\Contract\Services\ContractService;
use App\Feature\Contract\Requests\ContractStoreRequest; // Import the ContractStoreRequest class
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ContractController extends Controller
{
    protected $contractService;

    public function __construct(ContractService $contractService)
    {
        $this->contractService = $contractService;
    }
    public function store(ContractStoreRequest $request)
    {
        Log::info('Contract store method called in ContractController');
        
        // Validate the request data
        $validatedData = $request->validated();
        
        // Format start_date and end_date values to match MySQL datetime format
        $validatedData['start_date'] = Carbon::parse($validatedData['start_date'])->format('Y-m-d H:i:s');
        $validatedData['end_date'] = Carbon::parse($validatedData['end_date'])->format('Y-m-d H:i:s');
        

            $maxId = Contract::max('contract_id');

            // Increment the maximum contract_id by 1 or set it to 1 if no contracts exist
            $nextId = $maxId ? intval(substr($maxId, 2)) + 1 : 1;

            // Format the contract_id with the prefix 'CN' and leading zeros
            $contractId = 'CN' . str_pad($nextId, 10, '0', STR_PAD_LEFT);

            // Add contract_id to the validated data array
            $validatedData['contract_id'] = $contractId;

        
        // Ensure tenant_id is present in the validated data
        if (!isset($validatedData['tenant_id'])) {
            // Handle case where tenant_id is missing
            return response()->json(['error' => 'Tenant ID is missing.'], 422);
        }
        
        // Create the contract using the validated data
        $contract = $this->contractService->createContract($validatedData);
    
        // Return a JSON response with the created contract data and status code 201
        return response()->json($contract, 201);
    }
    
    
    

    public function show($contract_id)
    {
        Log::info('Contract show method called in ContractController');
        try {
            $contract = $this->contractService->getContractById($contract_id);
            return response()->json($contract);
        } catch (\Exception $e) {
            Log::error('Error fetching contract by ID: ' . $e->getMessage());
            return response()->json(['message' => 'Contract not found'], 404);
        }
    }

    public function index(Request $request)
    {
        Log::info('Contract index method called in ContractController');
        $contracts = $this->contractService->getAllContracts($request);
        return response()->json($contracts);
    }

    public function update(Request $request, $selectedContractId)
    {
        try {
            // Remove 'Category' field from the request data
            $requestData = $request->except('Category');
    
            $contract = $this->contractService->updateContract($selectedContractId, $requestData);
            return response()->json($contract);
        } catch (\Exception $e) {
            Log::error('Error updating contract: ' . $e->getMessage());
            return response()->json(['message' => 'Contract not found'], 404);
        }
    }
    

    public function deactivate($contract_id)
    {
        try {
            $contract = $this->contractService->deactivateContract($contract_id);
            $response = $contract->toArray();
            $response['message'] = 'Contract deactivated successfully';
            return response()->json($response, 200);
        } catch (\Exception $e) {
            Log::error('Error deactivating contract: ' . $e->getMessage());
            return response()->json(['message' => 'Contract not found'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            if ($this->contractService->deleteContract($id)) {
                return response()->json([
                    'id' => $id,
                    'deleted' => true,
                    'message' => 'Contract deleted successfully',
                ], 200);
            }
            return response()->json(['message' => 'Contract not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error deleting contract: ' . $e->getMessage());
            return response()->json(['message' => 'Contract not found'], 404);
        }
    }
    public function selectcust($query)
    {
        Log::info('Cust show method called in Cust Controller');
        try {
            $cust = $this->contractService->getcustbyname($query);
            return response()->json($cust);
        } catch (\Exception $e) {
            Log::error('Error fetching customer by name: ' . $e->getMessage());
            return response()->json(['message' => 'Customer not found'], 404);
        }
    }
    public function fetchDataBySapCustCode($data)
    {
        Log::info('Cust show method called in Cust Controller');
        try {
            $cust = $this->contractService->getdatacust($data);
            return response()->json($cust);
        } catch (\Exception $e) {
            Log::error('Error fetching customer by name: ' . $e->getMessage());
            return response()->json(['message' => 'Customer not found'], 404);
        }
    }
    
}
