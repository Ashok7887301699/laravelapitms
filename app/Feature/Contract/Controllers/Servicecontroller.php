<?php

namespace App\Feature\Contract\Controllers;

use App\Feature\Contract\Requests\Servicerequest;
use App\Feature\Contract\Services\SelectionService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Servicecontroller extends Controller
{
    protected $selectionService;

    public function __construct(SelectionService $selectionService)
    {
        $this->selectionService = $selectionService;
    }

    public function store(Servicerequest $request)
    {
        $validatedData = $request->validated();
        // Call the createService method and pass the validated data
        $contractService = $this->selectionService->createService($validatedData);
    
        if ($contractService) {
            return response()->json($contractService, 201); // 201 Created
        } else {

            Log::error('Failed to create Service Selection in Servicecontroller@store', ['request' => $validatedData]);

            // Return an error response
            return response()->json([
                'message' => 'Failed to create Service Selection',
                'errors' => 'There was an error processing the request',
            ], 500); 
        }
    }

    public function index()
    {
        Log::info('Service Selection called');
        $services = $this->selectionService->getAllServices();

        return response()->json($services);
    }

    public function show($contract_id)
    {
        $service = $this->selectionService->getServiceById($contract_id);
        return response()->json($service);
    }

    public function update(Request $request, $contract_id)
    {
        $service = $this->selectionService->updateServiceById($contract_id, $request->all());

        return response()->json($service);
    }
}
