<?php

namespace App\Feature\Contract\Controllers;

use App\Http\Controllers\Controller;
use App\Feature\Contract\Requests\ContractSlabRateRequest;
use App\Feature\Contract\Services\ContractSlabRateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContractSlabRateController extends Controller
{
    protected $contractSlabRateService;

    public function __construct(ContractSlabRateService $contractSlabRateService)
    {
        $this->contractSlabRateService = $contractSlabRateService;
    }

   

    
    
    public function store(Request $request)
    {
        Log::info('ContractSlabRate store method called in ContractSlabRateController');
        try {
            $requestData = $request->all();
            
            if (!isset($requestData['data']) || !is_array($requestData['data'])) {
                throw new \InvalidArgumentException('Data not provided or invalid format.');
            }
            
            $createdContractSlabRates = [];
    
            foreach ($requestData['data'] as $data) {
                // Assuming you have a model and service for creating contract slab rates
                // Example value, replace with your actual logic
                $contractSlabRate = $this->contractSlabRateService->createContractSlabRate($data);
                $createdContractSlabRates[] = $contractSlabRate;
            }
    
            return response()->json($createdContractSlabRates, 201); // 201 Created
        } catch (\Exception $e) {
            Log::error('Error creating ContractSlabRates: ' . $e->getMessage());
            return response()->json(['message' => 'Error creating ContractSlabRates'], 500);
        }
    }
    




    public function show($id)
    {
        Log::info('ContractSlabRate show method called in ContractSlabRateController');
        try {
            $contractSlabRate = $this->contractSlabRateService->getContractSlabRateById($id);
            return response()->json($contractSlabRate);
        } catch (\Exception $e) {
            Log::error('Error fetching ContractSlabRate by ID: ' . $e->getMessage());
            return response()->json(['message' => 'ContractSlabRate not found'], 404);
        }
    }

    public function index(Request $request)
    {
        Log::info('ContractSlabRate index method called in ContractSlabRateController');
        $contractSlabRates = $this->contractSlabRateService->getAllContractSlabRates($request);
        return response()->json($contractSlabRates);
    }

    public function update(Request $request, $id)
    {
        try {
            $contractSlabRate = $this->contractSlabRateService->updateContractSlabRate($id, $request->all());
            return response()->json($contractSlabRate);
        } catch (\Exception $e) {
            Log::error('Error updating ContractSlabRate: ' . $e->getMessage());
            return response()->json(['message' => 'ContractSlabRate not found'], 404);
        }
    }



    public function destroy($id)
    {
        try {
            if ($this->contractSlabRateService->deleteContractSlabRate($id)) {
                return response()->json([
                    'id' => $id,
                    'deleted' => true,
                    'message' => 'ContractSlabRate deleted successfully',
                ], 200);
            }
            return response()->json(['message' => 'ContractSlabRate not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error deleting ContractSlabRate: ' . $e->getMessage());
            return response()->json(['message' => 'ContractSlabRate not found'], 404);
        }
    }
}
