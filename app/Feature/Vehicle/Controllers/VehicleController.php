<?php

namespace App\Feature\Vehicle\Controllers;

use App\Http\Controllers\Controller;
use App\Feature\Vehicle\Requests\VehicleRequest;
use App\Feature\Vehicle\Services\VehicleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    protected $VehicleService; // Corrected property name

    public function __construct(VehicleService $VehicleService) // Corrected parameter name
    {
        $this->VehicleService = $VehicleService; // Corrected property assignment
    }


    public function store(VehicleRequest $request)
    {
        Log::info('vehicle store method called in vehicle Controller');
        $validatedData = $request->validated();


        $uploadRc = $request->file('UploadRc');
        $uploadInsurance = $request->file('UploadInsuarance');
        $uploadPermit = $request->file('UploadPermit');
        $uploadPUC = $request->file('UploadPUC');

        // Generate unique filenames
        $rcFilename = uniqid() . '.' . $uploadRc->getClientOriginalExtension();
        $insuranceFilename = uniqid() . '.' . $uploadInsurance->getClientOriginalExtension();
        $permitFilename = uniqid() . '.' . $uploadPermit->getClientOriginalExtension();
        $pucFilename = uniqid() . '.' . $uploadPUC->getClientOriginalExtension();

        // Store files in the public/Vehicle directory
        Storage::makeDirectory('public/Vehicle');
        $rcPath = $uploadRc->storeAs('public/Vehicle', $rcFilename);
        $insurancePath = $uploadInsurance->storeAs('public/Vehicle', $insuranceFilename);
        $permitPath = $uploadPermit->storeAs('public/Vehicle', $permitFilename);
        $pucPath = $uploadPUC->storeAs('public/Vehicle', $pucFilename);

        // Update the validated data with file paths
        $validatedData['UploadRc'] = $rcPath;
        $validatedData['UploadInsuarance'] = $insurancePath;
        $validatedData['UploadPermit'] = $permitPath;
        $validatedData['UploadPUC'] = $pucPath;




        $vehicle= $this->VehicleService->createVehicle($validatedData);

        return response()->json(['message' => 'vehicle created successfully', 'vehicle' => $vehicle], 201);
    }

    public function show($SrNo)
    {
        Log::info('vehicle show method called in vehicle Controller');
        $vehicle = $this->VehicleService->getVehicleById($SrNo);

        if (!$vehicle) {
            return response()->json(['message' => 'vehicle not found'], 404);
        }

        return response()->json(['message' => 'Perticular vehicle fetched successfully', 'vehicle' => $vehicle]);
    }
    public function index(Request $request)
    {
        Log::info('vehicle index method called in vehicle Controller');
        $vehicle = $this->VehicleService->getAllVehicles($request);

        return response()->json(['message' => 'vehicle fetched successfully', 'vehicle' => $vehicle]);
    }

    public function fetchAllvehcpctmodel()
    {
        // Call the CityMasterService to fetch all states
        $vehcpctmodel = $this->VehicleService->fetchvehcpctmodel();
        // Return the fetched states
        return response()->json(['vehcpctmodel' => $vehcpctmodel], 200);
    }

    public function fetchVehiclecpct()
    {
        // Call the CityMasterService to fetch all states
        $vehiclecpct = $this->VehicleService->fetchVehiclecpct();

        // Return the fetched states
        return response()->json(['vehiclecpct' => $vehiclecpct], 200);
    }

    public function update(Request $request, $SrNo)
    {
        $vehicle = $this->VehicleService->updateVehicle($SrNo, $request->all());

        if (!$vehicle) {
            return response()->json(['message' => 'vehicle not found'], 404);
        }
        return response()->json(['message' => 'vehicle updated successfully', 'vehicle' => $vehicle]);
    }


    public function deactivate($SrNo)
    {
        $vehicle = $this->VehicleService->deactivateVehicle($SrNo);
        if ($vehicle) {
            $response = $vehicle->toArray(); // Convert the Eloquent model to an array
            $response['message'] = 'vehicle deactivated successfully';

            return response()->json($response, 200);
        }

        return response()->json([
            'SrNo' => $SrNo,
            'message' => 'vehicle not found',
        ], 404);
    }

    public function destroy($SrNo)
    {
        if ($this->VehicleService->deleteVehicle($SrNo)) {
            return response()->json([
                'SrNo' => $SrNo,
                'deleted' => true,
                'message' => 'Vehicle deleted successfully',
            ], 200);
        }

        return response()->json([
            'SrNo' => $SrNo,
            'message' => 'Vehicle not found',
        ], 404);
    }



}
