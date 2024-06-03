<?php

namespace App\Feature\Contract\Controllers;

use App\Feature\Contract\Requests\Excessrequest;
use App\Feature\Contract\Services\Excessweightservice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExcessController extends Controller
{
    protected $excessService;

    public function __construct(Excessweightservice $excessService)
    {
        $this->excessService = $excessService; // Corrected variable name
    }


    public function insert(Request $request)
    {
        $validatedData = $request->input('data');
    
        // Check if data is provided
        if (empty($validatedData)) {
            return response()->json([
                'message' => 'Failed to create entries',
                'errors' => 'No data provided',
            ], 400); // 400 Bad Request
        }
    
        // Call the createService method and pass the validated data
        $createdEntries = $this->excessService->createExcess($validatedData);
    
        if (!empty($createdEntries)) {
            return response()->json($createdEntries, 201); // 201 Created
        } else {
            return response()->json([
                'message' => 'Failed to create entries',
                'errors' => 'There was an error processing the request',
            ], 500); // 500 Internal Server Error
        }
    }
    
    
    public function index()
    {
        Log::info('Service Selection called');
        $excess = $this->excessService->getAllExcessweight(); // Corrected variable name

        return response()->json($excess);
    }

    public function getById($contract_id) // Corrected method name to follow convention
    {
        $excess = $this->excessService->getExcessById($contract_id); // Corrected method call
        return response()->json($excess);
    }

    public function update(Request $request, $id)
    {
        $excess = $this->excessService->updateExcessById($id, $request->all()); // Corrected method call

        return response()->json($excess);
    }
}
