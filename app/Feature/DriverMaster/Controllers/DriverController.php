<?php

namespace App\Feature\DriverMaster\Controllers;

use App\Http\Controllers\Controller;
use App\Feature\DriverMaster\Models\Driver;
use App\Feature\DriverMaster\Requests\DriverRequest;
use App\Feature\DriverMaster\Services\DriverService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    protected $driverService;

    public function __construct(DriverService $driverService)
    {
        $this->driverService = $driverService;
    }

    public function index(Request $request)
    {
        Log::info('Driver index method called in DriverController');
        $drivers = $this->driverService->getAllDrivers($request);

        return response()->json($drivers);
    }

    public function store(DriverRequest $request)
    {
        $validatedData = $request->validated();

        $driverPhoto = $request->file('DriverPhoto');
        Log::info('Got the drive photo');

        $panCard = $request->file('PanCard');
        Log::info('Got the pan card photo');
        
        $voterId = $request->file('VoterId');
        Log::info('Got the Voter id Photo');
        
        $adharCard = $request->file('AadharCard');
        Log::info('Got the Adhar card photo');
        
        $license = $request->file('License');
        Log::info('Got the License photo');

        $driverPhotoFilename = $validatedData['FirstName'] . '_' . now()->format('Ymd') . '_' . uniqid() . '.' . $driverPhoto->getClientOriginalExtension();
        $panCardFilename = $validatedData['FirstName'] . '_' . now()->format('Ymd') . '_' . uniqid() . '.' . $panCard->getClientOriginalExtension();
        $voterIdFilename = $validatedData['FirstName'] . '_' . now()->format('Ymd') . '_' . uniqid() . '.' . $voterId->getClientOriginalExtension();
        $adharCardFilename = $validatedData['FirstName'] . '_' . now()->format('Ymd') . '_' . uniqid() . '.' . $adharCard->getClientOriginalExtension();
        $licenseFilename = $validatedData['FirstName'] . '_' . now()->format('Ymd') . '_' . uniqid() . '.' . $license->getClientOriginalExtension();

        Storage::makeDirectory('public/DriverMasterPhotos/driverPhoto');
        Storage::makeDirectory('public/DriverMasterPhotos/panCard');
        Storage::makeDirectory('public/DriverMasterPhotos/voterId');
        Storage::makeDirectory('public/DriverMasterPhotos/adharCard');
        Storage::makeDirectory('public/DriverMasterPhotos/license');

        $driverPhotoPath = $driverPhoto->storeAs(
            'public/DriverMasterPhotos/driverPhoto',
            $driverPhotoFilename
        );
        $panCardPath = $panCard->storeAs(
            'public/DriverMasterPhotos/panCard',
            $panCardFilename
        );
        $voterIdPath = $voterId->storeAs(
            'public/DriverMasterPhotos/voterId',
            $voterIdFilename
        );
        $adharCardPath = $adharCard->storeAs(
            'public/DriverMasterPhotos/adharCard',
            $adharCardFilename
        );
        $licensePath = $license->storeAs(
            'public/DriverMasterPhotos/license',
            $licenseFilename
        );

        $validatedData['DriverPhoto'] = asset($driverPhotoPath);
        $validatedData['PanCard'] =  asset($panCardPath);
        $validatedData['VoterId'] = asset($voterIdPath);
        $validatedData['AadharCard'] = asset($adharCardPath);
        $validatedData['License'] = asset($licensePath);

        $validatedData['Status'] = 'ACTIVE';

        $driver = $this->driverService->createDriver($validatedData);

        return response()->json($driver, 201);
    }

    public function show($id)
    {
        Log::info('Driver show method called in DriverController');
        $driver = $this->driverService->getDriverById($id);

        return response()->json($driver);
    }

    public function update(Request $request, $id)
    {
        $driver = $this->driverService->updateDriver($id, $request->all());

        return response()->json($driver);
    }

    public function deactivate(Request $request, $id)
    {
        $response = $this->driverService->deactivateDriver($id);

        if (is_string($response)) {
            // Driver is already deactivated, return the response
            return response()->json(['message' => $response], 200);
        }

        if (!$response) {
            // Driver not found, return 404 response
            return response()->json([
                'Driver Code' => $id,
                'message' => 'Driver not found',
            ], 404);
        }

        // Driver successfully deactivated, return the driver information
        return response()->json(['data' => $response->toArray()], 200);
    }



    public function destroy(Request $request, $id)
    {
        $response = $this->driverService->deleteDriver($id);

        if (is_string($response)) {
            // Driver is already Deleted, return the response
            return response()->json(['message' => $response], 200);
        }

        if (!$response) {
            // Driver not found, return 404 response
            return response()->json([
                'Driver Code' => $id,
                'message' => 'Driver not found',
            ], 404);
        }
    }

    public function getDriverPhoto($id)
    {
        $driver = $this->driverService->getDriverById($id);
        if ($driver) {
            $driverphotoPath = asset($driver->DriverPhoto);
            return response()->file(storage_path('app/' . str_replace(url('/'), '', $driverphotoPath)));
        } else {
            abort(404);
        }
    }

    public function getPanCard($id)
    {
        $driver = $this->driverService->getDriverById($id);
        if ($driver) {
            $panCardPath = asset($driver->PanCard);
            return response()->file(storage_path('app/' . str_replace(url('/'), '', $panCardPath)));
        } else {
            abort(404);
        }
    }

    public function getVoterId($id)
    {
        $driver = $this->driverService->getDriverById($id);
        if ($driver) {
            $voterIdPath = asset($driver->VoterId);
            return response()->file(storage_path('app/' . str_replace(url('/'), '', $voterIdPath)));
        } else {
            abort(404);
        }
    }

    public function getAadharCard($id)
    {
        $driver = $this->driverService->getDriverById($id);
        if ($driver) {
            $adharCardPath = asset($driver->AadharCard);
            return response()->file(storage_path('app/' . str_replace(url('/'), '', $adharCardPath)));
        } else {
            abort(404);
        }
    }

    public function getLicense($id)
    {
        $driver = $this->driverService->getDriverById($id);
        if ($driver) {
            $licensePath = asset($driver->License);
            return response()->file(storage_path('app/' . str_replace(url('/'), '', $licensePath)));
        } else {
            abort(404);
        }
    }
}