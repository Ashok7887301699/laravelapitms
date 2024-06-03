<?php

namespace App\Feature\Vendor\Controllers;

use App\Feature\Vendor\Requests\VendorStoreRequest;
use App\Feature\Vendor\Services\VendorService;
use App\Http\Controllers\Controller;
use App\Feature\Vendor\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VendorController extends Controller
{
    protected $vendorService;

    public function __construct(VendorService $vendorService)
    {
        $this->vendorService = $vendorService;
    }

    public function store(VendorStoreRequest $request)
    {
        Log::info('Vendor store method called in VendorController');
        $validatedData = $request->validated();
        $vendor = $this->vendorService->createVendor($validatedData);

        return response()->json($vendor, 201); // 201 Created
    }




    public function show($id)
    {
        Log::info('Vendor show method called in VendorController');
        $vendor = $this->vendorService->getVendorById($id);

        return response()->json($vendor);
    }

    public function index(Request $request)
    {
        Log::info('Vendor index method called in VendorController');
        $Vendors = $this->vendorService->getAllVendor($request);

        return response()->json($Vendors);
    }

    public function update(Request $request, $id)
    {
        $vendor = $this->vendorService->updateVendor($id, $request->all());

        return response()->json($vendor);
    }

    public function deactivate($id)
    {
        $vendor = $this->vendorService->deactivateVendor($id);
        if ($vendor) {
            $response = $vendor->toArray(); // Convert the Eloquent model to an array
            $response['message'] = 'vendor deactivated successfully';

            return response()->json($response, 200);
        }

        return response()->json([
            'id' => $id,
            'message' => 'vendor not found',
        ], 404);
    }

    public function destroy($id)
    {
        if ($this->vendorService->deleteVendor($id)) {
            return response()->json([
                'id' => $id,
                'deleted' => true,
                'message' => 'vendor deleted successfully',
            ], 200);
        }

        return response()->json([
            'id' => $id,
            'message' => 'vendor not found',
        ], 404);
    }

    
public function importExcel(Request $request)
{
    Log::info('Vendor store method called in VendorController');

    if (!$request->isJson() || !$request->json()->all()) {
        return response()->json(['error' => 'No data provided'], 400); 
    }

    $vendorsData = $request->json()->all();

    $createdVendors = [];

    foreach ($vendorsData as $vendorData) {
        $requiredFields = ['VendorCode', 'VendorName', 'Type', 'Address', 'City', 'Depot', 'Vehicle', 'Pincode', 'Mobile_No', 'Email', 'PAN_No', 'GSTNO', 'BankName', 'AccountNO', 'IFSC', 'Category', 'U_Location', 'status'];
        
        if (count(array_intersect_key(array_flip($requiredFields), $vendorData)) !== count($requiredFields)) {
            return response()->json(['error' => 'Missing required fields'], 422); 
        }

        $vendor = Vendor::create($vendorData);

        $createdVendors[] = $vendor;
    }

    return response()->json($createdVendors, 201);

}
}