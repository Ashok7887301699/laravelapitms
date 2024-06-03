<?php

namespace App\Feature\PackageType\Controllers;

use App\Feature\PackageType\Requests\PackageTypeStoreRequest;
use App\Feature\PackageType\Services\PackageTypeService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PackageTypeController extends Controller
{
    protected $packagetypeService;

    public function __construct(PackageTypeService $packagetypeService)
    {
        $this->packagetypeService = $packagetypeService;
    }

    public function store(PackageTypeStoreRequest $request)
    {
        Log::info('PackageType store method called in PackageTypeController');
        $validatedData = $request->validated();
        $packagetype = $this->packagetypeService->createPackageType($validatedData);

        return response()->json($packagetype, 201); // 201 Created
    }

    public function show($id)
    {
        Log::info('PackageType show method called in PackageTypeController');
        $packagetype = $this->packagetypeService->getPackageTypeById($id);

        return response()->json($packagetype);
    }

    public function index(Request $request)
    {
        Log::info('PackageType index method called in PackageTypeController');
        $packagetypes = $this->packagetypeService->getAllPackageType($request);

        return response()->json($packagetypes);
    }

    public function update(Request $request, $id)
    {
        $packagetype = $this->packagetypeService->updatePackageType($id, $request->all());

        return response()->json($packagetype);
    }

    public function deactivate($id)
    {
        $packagetype = $this->packagetypeService->deactivatePackageType($id);
        if ($packagetype) {
            $response = $packagetype->toArray(); // Convert the Eloquent model to an array
            $response['message'] = 'PackageType deactivated successfully';

            return response()->json($response, 200);
        }

        return response()->json([
            'id' => $id,
            'message' => 'PackageType not found',
        ], 404);
    }

    public function destroy($id)
    {
        if ($this->packagetypeService->deletePackageType($id)) {
            return response()->json([
                'id' => $id,
                'deleted' => true,
                'message' => 'PackageType deleted successfully',
            ], 200);
        }

        return response()->json([
            'id' => $id,
            'message' => 'PackageType not found',
        ], 404);
    }

    // Further methods for other operations (read, update, delete) can be added here
}
