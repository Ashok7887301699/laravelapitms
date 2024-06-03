<?php

namespace App\Feature\VehicleCapacityModel\Controllers;

use App\Feature\VehicleCapacityModel\Requests\VehicleCapacityModelStoreRequest;
use App\Feature\VehicleCapacityModel\Services\VehicleCapacityModelService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VehicleCapacityModelController extends Controller
{
    protected $vehiclecapacitymodelService;

    public function __construct(VehicleCapacityModelService $vehiclecapacitymodelService)
    {
        $this->vehiclecapacitymodelService = $vehiclecapacitymodelService;
    }

    public function store(VehicleCapacityModelStoreRequest $request)
    {
        Log::info('VehicleCapacityModel store method called in VehicleCapacityModelController');
        $validatedData = $request->validated();
        $vehiclecapacitymodel = $this->vehiclecapacitymodelService->createVehicleCapacityModel($validatedData);

        return response()->json($vehiclecapacitymodel, 201); // 201 Created
    }
    

    public function show($id)
    {
        Log::info('VehicleCapacityModel show method called in VehicleCapacityModelController');
        $vehiclecapacitymodel = $this->vehiclecapacitymodelService->getVehicleCapacityModelById($id);

        return response()->json($vehiclecapacitymodel);
    }

    public function index(Request $request)
    {
        Log::info('VehicleCapacityModel index method called in VehicleCapacityModelController');
        $vehiclecapacitymodels = $this->vehiclecapacitymodelService->getAllVehicleCapacityModels($request);

        return response()->json($vehiclecapacitymodels);
    }

    public function update(Request $request, $id)
    {
        $vehiclecapacitymodel = $this->vehiclecapacitymodelService->updateVehicleCapacityModel($id, $request->all());

        return response()->json($vehiclecapacitymodel);
    }

    public function deactivate($id)
    {
        $vehiclecapacitymodel = $this->vehiclecapacitymodelService->deactivateVehicleCapacityModel($id);
        if ($vehiclecapacitymodel) {
            $response = $vehiclecapacitymodel->toArray(); // Convert the Eloquent model to an array
            $response['message'] = 'VehicleCapacityModel deactivated successfully';

            return response()->json($response, 200);
        }

        return response()->json([
            'id' => $id,
            'message' => 'VehicleCapacityModel not found',
        ], 404);
    }

    public function destroy($id)
    {
        if ($this->vehiclecapacitymodelService->deleteVehicleCapacityModel($id)) {
            return response()->json([
                'id' => $id,
                'deleted' => true,
                'message' => 'VehicleCapacityModel deleted successfully',
            ], 200);
        }

        return response()->json([
            'id' => $id,
            'message' => 'VehicleCapacityModel not found',
        ], 404);
    }

    // Further methods for other operations (read, update, delete) can be added here
}
