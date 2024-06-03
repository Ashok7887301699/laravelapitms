<?php


namespace App\Feature\Branch\Controllers;


use App\Http\Controllers\Controller;
use App\Feature\Branch\Requests\BranchTypeStoreRequest;

use App\Feature\Branch\Services\BranchTypeService;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class BranchTypeController extends Controller
{
    protected $branchTypeService;

    public function __construct(BranchTypeService $branchTypeService)
    {
        $this->branchTypeService = $branchTypeService;
    }

    public function store(BranchTypeStoreRequest $request)
    {
        Log::debug('BranchType store method called in BranchTypeController');
        $validatedData = $request->validated();
        $branchType = $this->branchTypeService->createBranchType($validatedData);

        if ($branchType) {
            return response()->json($branchType, 201); // 201 Created
        } else {
            // Log the error
            Log::error('Failed to create branch type in BranchTypeController@store', ['request' => $validatedData]);

            // Return an error response
            return response()->json([
                'message' => 'Failed to create branch type',
                'errors' => 'There was an error processing the request',
            ], 500); // 500 Internal Server Error
        }
    }

    public function show($id)
    {
        Log::debug("BranchType show method called in BranchTypeController for ID: $id");
        $branchType = $this->branchTypeService->getBranchTypeById($id);

        if (!$branchType) {
            Log::error("Branch type with ID: $id not found in BranchTypeController@show");

            return response()->json(['message' => 'Branch type not found'], 404);
        }

        return response()->json($branchType);
    }

    public function index(Request $request)
    {
        Log::debug('BranchType index method called in BranchTypeController');

        try {
            $branchTypes = $this->branchTypeService->getAllBranchTypes($request);

            if ($branchTypes->isEmpty()) {
                Log::info('No branch types found in BranchTypeController@index');
            }

            return response()->json($branchTypes);
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error in BranchTypeController@index: ' . $e->getMessage());

            // Return an error response
            return response()->json([
                'message' => 'Error fetching branch types',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error
        }
    }

    public function update(BranchTypeStoreRequest $request, $id)
    {
        Log::debug("BranchType update method called in BranchTypeController for ID: $id");
        $validatedData = $request->validated();
        $branchType = $this->branchTypeService->updateBranchType($id, $validatedData);

        if (!$branchType) {
            Log::error("Branch type with ID: $id not found in BranchTypeController@update");

            return response()->json(['message' => 'Branch type not found'], 404);
        }

        return response()->json($branchType);
    }

    public function deactivate(BranchTypeStoreRequest $request, $id)
    {
        Log::debug("Deactivating branch type with ID: $id in BranchTypeController");
        $branchType = $this->branchTypeService->deactivateBranchType($id);

        if ($branchType) {
            Log::info("Branch type with ID: $id deactivated successfully");
            $response = $branchType->toArray();
            $response['message'] = 'Branch type deactivated successfully';

            return response()->json($response, 200);
        }

        Log::error("Branch type with ID: $id not found for deactivation");

        return response()->json(['message' => 'Branch type not found'], 404);
    }

    public function destroy($id)
    {
        Log::debug("Attempting to delete branch type with ID: $id in BranchTypeController");
        if ($this->branchTypeService->deleteBranchType($id)) {
            Log::info("Branch type with ID: $id deleted successfully");

            return response()->json(['id' => $id, 'deleted' => true, 'message' => 'Branch type deleted successfully'], 200);
        }

        Log::error("Branch type with ID: $id not found for deletion");

        return response()->json(['id' => $id, 'message' => 'Branch type not found'], 404);
    }

    public function getBranchTypes(Request $request)
    {
        Log::debug('Fetching active branch types in BranchTypeController@getBranchTypes');

        try {
            $branchTypes = $this->branchTypeService->getAllBranchTypesOnly();

            if (empty ($branchTypes)) {
                Log::info('No branch types found in BranchTypeController@getBranchTypes');
                return response()->json(['message' => 'No branch types found'], 404);
            }

            return response()->json($branchTypes);
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error in BranchTypeController@getBranchTypes: ' . $e->getMessage());

            // Return an error response
            return response()->json([
                'message' => 'Error fetching branch types',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error
        }
    }

}
