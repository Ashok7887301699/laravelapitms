<?php

namespace App\Feature\VendorFuel\Controllers;

use App\Feature\VendorFuel\Requests\VendorFuelStoreRequest;
use App\Feature\VendorFuel\Services\VendorFuelService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VendorFuelController extends Controller
{
    protected $vendorfuelService;

    public function __construct(VendorFuelService $vendorfuelService)
    {
        $this->vendorfuelService = $vendorfuelService;
    }

    public function store(VendorFuelStoreRequest $request)
    {
        Log::info('VendorFuel store method called in VendorFuelController');
        $validatedData = $request->validated();
        $vendorfuel = $this->vendorfuelService->createVendorFuel($validatedData);

        return response()->json($vendorfuel, 201); // 201 Created
    }

    public function show($id)
    {
        Log::info('VendorFuel show method called in VendorFuelController');
        $vendorfuel = $this->vendorfuelService->getVendorFuelById($id);

        return response()->json($vendorfuel);
    }

    public function index(Request $request)
    {
        Log::info('VendorFuel index method called in VendorFuelController');
        $vendorfuels = $this->vendorfuelService->getAllVendorFuel($request);

        return response()->json($vendorfuels);
    }

    public function update(Request $request, $id)
    {
        $vendorfuel = $this->vendorfuelService->updateVendorFuel($id, $request->all());

        return response()->json($vendorfuel);
    }

    public function deactivate($id)
    {
        $vendorfuel = $this->vendorfuelService->deactivateVendorFuel($id);
        if ($vendorfuel) {
            $response = $vendorfuel->toArray(); // Convert the Eloquent model to an array
            $response['message'] = 'VendorFuel deactivated successfully';

            return response()->json($response, 200);
        }

        return response()->json([
            'id' => $id,
            'message' => 'VendorFuel not found',
        ], 404);
    }

    public function destroy($id)
    {
        if ($this->vendorfuelService->deleteVendorFuel($id)) {
            return response()->json([
                'id' => $id,
                'deleted' => true,
                'message' => 'VendorFuel deleted successfully',
            ], 200);
        }

        return response()->json([
            'id' => $id,
            'message' => 'VendorFuel not found',
        ], 404);
    }

    // Further methods for other operations (read, update, delete) can be added here
}
