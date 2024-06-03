<?php

namespace App\Feature\TyreInventoryMaster\Controllers;

use App\Feature\TyreInventoryMaster\Requests\TyreInventoryMasterStoreRequest;
use App\Feature\TyreInventoryMaster\Services\TyreInventoryMasterService;
use App\Feature\TyreInventoryMaster\Models\TyreInventoryMaster;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TyreInventoryMasterController extends Controller
{
    protected $TyreInventoryMasterService;

    public function __construct(TyreInventoryMasterService $TyreInventoryMasterService)
    {
        $this->TyreInventoryMasterService = $TyreInventoryMasterService;
    }

    public function store(TyreInventoryMasterStoreRequest $request)
{
    Log::info('Tyre Inventory Master store method called in Tyre Inventory Master Controller');

    // Validate the request data
    $validatedData = $request->validated();

    // Generate tyre_code
    $id = TyreInventoryMaster::max('id');
    $nextId = $id + 1;
    $tyre_code = 'TYR' . str_pad($nextId, 7, '0', STR_PAD_LEFT);

    // Add tyre_code to validated data array
    $validatedData['tyre_code'] = $tyre_code;

    // Create the Tyre Inventory Master record
    $TyreInventoryMaster = $this->TyreInventoryMasterService->createTyreInventoryMaster($validatedData);

    return response()->json($TyreInventoryMaster, 201); // 201 Created
}
    public function show($id)
    {
        Log::info('Tyre Inventory Master show method called in Tyre Inventory Master Controller');
        $TyreInventoryMaster = $this->TyreInventoryMasterService->getTyreInventoryMasterById($id);

        return response()->json($TyreInventoryMaster);
    }

    public function index(Request $request)
    {
        Log::info('Tyre Inventory Master index method called in Tyre Inventory Master Controller');
        $TyreInventoryMasters = $this->TyreInventoryMasterService->getAllTyreInventoryMaster($request);

        return response()->json($TyreInventoryMasters);
    }

    public function update(Request $request, $id)
    {
        $TyreInventoryMaster = $this->TyreInventoryMasterService->updateTyreInventoryMaster($id, $request->all());

        return response()->json($TyreInventoryMaster);
    }

    public function deactivate($id)
    {
        $TyreInventoryMaster = $this->TyreInventoryMasterService->deactivateTyreInventoryMaster($id);
        if ($TyreInventoryMaster) {
            $response = $TyreInventoryMaster->toArray(); // Convert the Eloquent model to an array
            $response['message'] = 'Tyre Inventory Master deactivated successfully';

            return response()->json($response, 200);
        }

        return response()->json([
            'id' => $id,
            'message' => 'Tyre Inventory Master not found',
        ], 404);
    }

    public function destroy($id)
    {
        if ($this->TyreInventoryMasterService->deleteTyreInventoryMaster($id)) {
            return response()->json([
                'id' => $id,
                'deleted' => true,
                'message' => 'Tyre Inventory Master deleted successfully',
            ], 200);
        }

        return response()->json([
            'id' => $id,
            'message' => 'Tyre Inventory Master not found',
        ], 404);
    }

    // Further methods for other operations (read, update, delete) can be added here
}
