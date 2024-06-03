<?php

namespace App\Feature\CityMaster\Services;

use App\Feature\CityMaster\Models\CityMaster;
use App\Feature\CityMaster\Repositories\CityMasterRepository;
use App\Feature\CityMaster\Models\IndiaState;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;


class CityMasterService
{
    protected $citymasterRepository;

    public function __construct(CityMasterRepository $citymasterRepository)
    {
        $this->citymasterRepository = $citymasterRepository;
    }

   //public function createCityMaster(array $data)
//{
 //   return $this->citymasterRepository->create($data);
//}

 //public function createCityMasters(array $cityMasters)
  //  {
  //      $createdCityMasters = [];

 //       foreach ($cityMasters as $data) {
  //          $createdCityMasters[] = $this->citymasterRepository->create($data);
//}

    //    return $createdCityMasters;
   // }

// public function createCityMasters(array $cityMasters)
// {
//     $createdCityMasters = [];
//     $duplicateCityNames = [];

//     foreach ($cityMasters as $data) {
//         try {
//             // Check if the city already exists based on CityNameEng
//             $existingCity = $this->citymasterRepository->findByCityNameEng($data['CityNameEng']);

//             if ($existingCity) {
//                 // Check if the taluka is the same as the existing city
//                 if ($existingCity->Taluka !== $data['Taluka']) {
//                     // Different taluka, continue to create the city
//                     $createdCityMasters[] = $this->citymasterRepository->create($data);
//                 } else {
//                     // Same taluka, log it and continue to the next record
//                     Log::info('City with name ' . $data['CityNameEng'] . ' already exists with the same taluka. Skipping record.');
//                     $duplicateCityNames[] = $data['CityNameEng']; // Store the duplicate city name
//                 }
//                 continue;
//             }

//             // City does not exist, create it
//             $createdCityMasters[] = $this->citymasterRepository->create($data);
//         } catch (QueryException $e) {
//             // Other database-related errors
//             Log::error('Database error: ' . $e->getMessage());
//             // Handle the error as needed
//         }
//     }

//     if (!empty($duplicateCityNames)) {
//         // Return the duplicate city names in the error response
//         throw new \Exception('Duplicate city names found: ' . implode(', ', $duplicateCityNames));
//     }

//     return $createdCityMasters;
// }


//   public function createCityMasterform(array $data)
//     {
//         return $this->citymasterRepository->create($data);
//     }


public function createCityMasters(array $cityMasters)
{
    $createdCityMasters = [];
    $duplicateCityNames = [];

    foreach ($cityMasters as $data) {
        try {
            // Check if the city already exists based on CityNameEng and Taluka
            $existingCity = $this->citymasterRepository->findByCityNameAndTaluka($data['CityNameEng'], $data['Taluka']);

            if ($existingCity) {
                // Same city name and taluka found, log it and continue to the next record
                Log::info('City with name ' . $data['CityNameEng'] . ' and Taluka ' . $data['Taluka'] . ' already exists. Skipping record.');
                $duplicateCityNames[] = $data['CityNameEng']; // Store the duplicate city name
                continue;
            }

            // City does not exist with the same city name and taluka, create it
            $createdCityMasters[] = $this->citymasterRepository->create($data);
        } catch (QueryException $e) {
            // Other database-related errors
            Log::error('Database error: ' . $e->getMessage());
            // Handle the error as needed
        }
    }

    if (!empty($duplicateCityNames)) {
        // Return the duplicate city names in the error response
        throw new \Exception('Duplicate city names found: ' . implode(', ', $duplicateCityNames));
    }

    return $createdCityMasters;
}





    public function getCityMasterById($id)
    {
        return $this->citymasterRepository->find($id);
    }

public function getAllCityMaster($request)
{
    $query = CityMaster::query();

    // Filter by 'name'
    if ($request->has('CityNameEng')) {
        $query->where('CityNameEng', 'like', '%' . $request->CityNameEng . '%');
    }

     if ($request->has('Pincode')) {
        $query->where('Pincode', 'like', '%' . $request->Pincode . '%');
    }
      if ($request->has('status')) {
            $query->where('status', $request->status);
        }

    if ($request->has('District')) {
        $query->where('District', 'like', '%' . $request->District . '%');
    }

    if ($request->has('Taluka')) {
        $query->where('Taluka', 'like', '%' . $request->Taluka . '%');
    }

    // Filter by 'created_at' date range
    if ($request->has(['created_from', 'created_to'])) {

          $query->whereBetween('created_at', [$request->created_from, $request->created_to]);
    }

    // Filter by 'updated_at' date range
    if ($request->has(['updated_from', 'updated_to'])) {
        $query->whereBetween('updated_at', [$request->updated_from, $request->updated_to]);
    }

    // Sorting
    $query->orderBy($request->get('sort_by', 'updated_at'), $request->get('sort_order', 'desc'));

    // Pagination
    $perPage = $request->get('per_page', 10); // Default to 10 if not provided

    return $query->paginate($perPage);
}

 public function getAlldataexportexcellCityMaster($request)
{
    // Fetch all data without pagination
    $data = CityMaster::all();

    // Return the data for exporting to Excel
    return response()->json($data);
}



    public function updateCityMaster($id, array $data)
    {
        $citymaster = $this->citymasterRepository->find($id);
        if ($citymaster) {
            $citymaster->update($data);
        }

        return $citymaster;
    }

    public function deactivateCityMaster($id)
    {
        $citymaster = $this->citymasterRepository->find($id);
        if ($citymaster) {
            $citymaster->update(['status' => 'DEACTIVATED']);

            return $citymaster;
        }

        return null; // Handle the case where the citymaster is not found
    }

    public function deleteCityMaster($id)
    {
        $citymaster = $this->citymasterRepository->find($id);
        if ($citymaster) {
            $citymaster->delete();

            return true;
        }

        return false;
    }

 public function fetchStates()
{

    $states = IndiaState::groupBy('State')->pluck('State')->toArray();

    return $states;
}

public function fetchDistricts(string $state): array
{
    // Retrieve districts based on the selected state
    $districts = IndiaState::where('State', $state)
                    ->groupBy('District')
                    ->pluck('District')
                    ->toArray();

    return $districts;
}

public function fetchTalukas(string $district): array
{
    // Retrieve talukas based on the selected district
    $talukas = IndiaState::where('District', $district)
                    ->groupBy('Taluka')
                    ->pluck('Taluka')
                    ->toArray();

    return $talukas;
}


public function fetchPostnames(string $taluka): array
{
    // Retrieve postnames based on the selected taluka
    $postnames = IndiaState::where('Taluka', $taluka)->pluck('Postoffice')->toArray();

    return $postnames;
}

public function fetchPincodes(string $postname): array
{
    // Retrieve pincodes based on the selected postname
    $pincodes = IndiaState::where('Postoffice', $postname)->pluck('Post_Pincode')->toArray();

    return $pincodes;
}



}
