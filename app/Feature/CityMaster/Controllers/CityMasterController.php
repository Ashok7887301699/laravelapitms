<?php

namespace App\Feature\CityMaster\Controllers;

use App\Feature\CityMaster\Requests\CityMasterStoreRequest;
use App\Feature\CityMaster\Services\CityMasterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;



class CityMasterController extends Controller
{
    protected $cityMasterService; // Corrected property name

    public function __construct(CityMasterService $cityMasterService) // Corrected parameter name
    {
        $this->cityMasterService = $cityMasterService;
    }

//public function store(CityMasterStoreRequest $request, CityMasterService $cityMasterService)
//{
  //  Log::info('CityMaster store method called in CityMasterController');
    //$validatedData = $request->validated();
    
    //$cityMasters = $validatedData['data'];

    // Call the service to create city masters
//    $createdCityMasters = $cityMasterService->createCityMasters($cityMasters);

  //  return response()->json($createdCityMasters, 201); // 201 Created
//}

public function store(CityMasterStoreRequest $request, CityMasterService $cityMasterService)
{
    Log::info('CityMaster store method called in CityMasterController');
    $validatedData = $request->validated();
    
    $cityMasters = $validatedData['data'];

    foreach ($cityMasters as &$data) {
        // Set status to ACTIVE
        $data['status'] = 'ACTIVE'; // Change 'Status' to 'status'
    }

    // Call the service to create city masters
    $createdCityMasters = $cityMasterService->createCityMasters($cityMasters);

    return response()->json($createdCityMasters, 201); // 201 Created
}


// public function storeform(CityMasterStoreRequest $request)
// {
//     Log::info('CityMaster store method called in CityMasterController');
   
//     // Retrieve validated data from the request
//     $data = $request->validated();

//     // Pass the data to the service method
//     $citymaster = $this->cityMasterService->createCityMasterform($data);

//     return response()->json($citymaster, 201); // 201 Created
// }




    public function show($id)
    {
        Log::info('CityMaster show method called in CityMasterController');
        $citymaster = $this->cityMasterService->getCityMasterById($id);

        return response()->json($citymaster);
    }

    public function index(Request $request)
    {
        Log::info('CityMaster index method called in CityMasterController');
        $citymasters = $this->cityMasterService->getAllCityMaster($request);

        return response()->json($citymasters);
    }


  public function getalldata(Request $request)
{
    Log::info('CityMaster index method called in CityMasterController');
    $citymasters = $this->cityMasterService->getAlldataexportexcellCityMaster($request);

    return response()->json($citymasters);
}

    public function update(Request $request, $id)
    {
        $cityMaster = $this->cityMasterService->updateCityMaster($id, $request->all());

        return response()->json($cityMaster);
    }

    public function deactivate($id)
    {
        $cityMaster = $this->cityMasterService->deactivateCityMaster($id);
        if ($cityMaster) {
            $response = $cityMaster->toArray(); // Convert the Eloquent model to an array
            $response['message'] = 'CityMaster deactivated successfully';

            return response()->json($response, 200);
        }

        return response()->json([
            'id' => $id,
            'message' => 'CityMaster not found',
        ], 404);
    }

    public function destroy($id)
    {
        if ($this->cityMasterService->deleteCityMaster($id)) {
            return response()->json([
                'id' => $id,
                'deleted' => true,
                'message' => 'CityMaster deleted successfully',
            ], 200);
        }

        return response()->json([
            'id' => $id,
            'message' => 'CityMaster not found',
        ], 404);
    }

  public function fetchAllStates()
    {
        // Call the CityMasterService to fetch all states
        $states = $this->cityMasterService->fetchStates();

        // Return the fetched states
        return response()->json(['states' => $states], 200);
    }

   public function fetchDistricts(Request $request, $state = null)
{
    // If state is not provided in the route, try getting it from the query parameters
    if ($state === null) {
        $state = $request->input('state');
    }

    // Call the CityMasterService to fetch districts based on the selected state
    $districts = $this->cityMasterService->fetchDistricts($state);

    // Return the fetched districts
    return response()->json(['districts' => $districts], 200);
}

public function fetchTalukas(Request $request, $district = null)
{
    // If district is not provided in the route, try getting it from the query parameters
    if ($district === null) {
        $district = $request->input('district');
    }

    // Call the CityMasterService to fetch talukas based on the selected district
    $talukas = $this->cityMasterService->fetchTalukas($district);

    // Return the fetched talukas
    return response()->json(['talukas' => $talukas], 200);
}

public function fetchPostnames(Request $request, $taluka = null)
{
    // If taluka is not provided in the route, try getting it from the query parameters
    if ($taluka === null) {
        $taluka = $request->input('taluka');
    }

    // Call the CityMasterService to fetch postnames based on the selected taluka
    $postnames = $this->cityMasterService->fetchPostnames($taluka);

    // Return the fetched postnames
    return response()->json(['postnames' => $postnames], 200);
}

// In your CityMasterController:

public function fetchPincodes(Request $request, $postname = null)
{
    // If postname is not provided in the route, try getting it from the query parameters
    if ($postname === null) {
        $postname = $request->input('postname');
    }

    // Call the CityMasterService to fetch pincodes based on the selected postname
    $pincodes = $this->cityMasterService->fetchPincodes($postname);

    // Return the fetched pincodes
    return response()->json(['pincodes' => $pincodes], 200);
}



}