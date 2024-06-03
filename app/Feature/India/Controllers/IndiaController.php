<?php

namespace App\Feature\India\Controllers;

use App\Feature\India\Requests\IndiaStoreRequest;
use App\Feature\India\Requests\IndiaUpdateRequest;
use App\Feature\India\Services\IndiaService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IndiaController extends Controller
{
    protected $indiaService;

    public function __construct(IndiaService $indiaService)
    {
        $this->indiaService = $indiaService;
    }

    public function store(IndiaStoreRequest $request)
    {
        Log::debug('India store method called in IndiaController');
        $validatedData = $request->validated();
        $india = $this->indiaService->createIndia($validatedData);

        if ($india) {
            return response()->json($india, 201); // 201 Created
        } else {
            // Log the error
            Log::error('Failed to create india in IndiaController@store', ['request' => $validatedData]);

            // Return an error response
            return response()->json([
                'message' => 'Failed to create india',
                'errors' => 'There was an error processing the request',
            ], 500); // 500 Internal Server Error
        }
    }

    public function show($id)
    {
        Log::debug("India show method called in IndiaController for ID: $id");
        $india = $this->indiaService->getIndiaById($id);

        if (! $india) {
            Log::error("India with ID: $id not found in IndiaController@show");

            return response()->json(['message' => 'India not found'], 404);
        }

        return response()->json($india);
    }

    public function index(Request $request)
    {
        Log::debug('India index method called in IndiaController');

        try {
            $india = $this->indiaService->getAllIndias($request);

            if ($india->isEmpty()) {
                Log::info('No tenants found in IndiaController@index');
            }

            return response()->json($india);
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error in IndiaController@index: '.$e->getMessage());

            // Return an error response
            return response()->json([
                'message' => 'Error fetching india',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error
        }
    }

    public function update(IndiaUpdateRequest $request, $id)
    {
        Log::debug("India update method called in IndiaController for ID: $id");
        $validatedData = $request->validated();
        $india = $this->indiaService->updateIndia($id, $validatedData);

        if (! $india) {
            Log::error("India with ID: $id not found in IndiaController@update");

            return response()->json(['message' => 'India not found'], 404);
        }

        return response()->json($india);
    }

    public function deactivate($id)
    {
        Log::debug("Deactivating india with ID: $id in IndiaController");
        $india = $this->indiaService->deactivateIndia($id);

        if ($india) {
            Log::info("India with ID: $id deactivated successfully");
            $response = $india->toArray();
            $response['message'] = 'India deactivated successfully';

            return response()->json($response, 200);
        }

        Log::error("India with ID: $id not found for deactivation");

        return response()->json(['message' => 'India not found'], 404);
    }

    public function destroy($id)
    {
        Log::debug("Attempting to delete india with ID: $id in IndiaController");
        if ($this->indiaService->deleteIndia($id)) {
            Log::info("India with ID: $id deleted successfully");

            return response()->json(['id' => $id, 'deleted' => true, 'message' => 'India deleted successfully'], 200);
        }

        Log::error("India with ID: $id not found for deletion");

        return response()->json(['id' => $id, 'message' => 'India not found'], 404);
    }
}
