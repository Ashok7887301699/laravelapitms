<?php

namespace App\Feature\PickupRequestNote\Controllers;

use App\Feature\PickupRequestNote\Models\PickupRequestNote; // Import the PickupRequestNote model
use App\Feature\PickupRequestNote\Requests\PickupRequestNoteStoreRequest;
use App\Feature\PickupRequestNote\Services\PickupRequestNoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class PickupRequestNoteController extends Controller
{
    protected $pickupRequestNoteService;

    public function __construct(PickupRequestNoteService $pickupRequestNoteService)
    {
        $this->pickupRequestNoteService = $pickupRequestNoteService;
    }  



public function store(PickupRequestNoteStoreRequest $request)
{
    $maxPRNNumber = PickupRequestNote::max('id');
    preg_match('/\d+$/', $maxPRNNumber, $matches);
    $maxprnNumberNumericPart = isset($matches[0]) ? (int)$matches[0] : 0;
    $newId = $maxprnNumberNumericPart + 1;
    $newprnNumber = "PR/PNA/2425/" . str_pad($newId, 6, '0', STR_PAD_LEFT);

    Log::debug('PickupRequestNote store method called in PickupRequestNoteController');
    $validatedData = $request->validated();

    // Create fm_prn record
    $pickupRequestNoteData = $validatedData;
    
    $pickupRequestNoteData['id'] = $newprnNumber;
     $pickupRequestNoteData['tenant_id'] = "1";
    
    $pickupRequestNoteData['trip_id'] = $newprnNumber;
     $pickupRequestNoteData['trip_type'] = "PRN";
     $pickupRequestNoteData['action'] = "LOADING";
    $pickupRequestNote = $this->pickupRequestNoteService->createPickupRequestNote($pickupRequestNoteData);

    // Create fm_loader_expense record
    $this->pickupRequestNoteService->createLoaderExpense($pickupRequestNoteData);

    // Create prn_lr_data and fb_lr_state_log records
foreach ($validatedData['prn_lr_data'] as $prnLr) {
    $prnLrData = [
        'prn_id' => $newprnNumber,
        'lr_id' => $prnLr['lr_id'],
        
        'tenant_id' => "1", // Assuming these fields are coming from $prnLr
        'status' => "PRN_CREATED",
        //'consignment_location_id' => $prnLr['consignment_location_id'],
        // 'total_num_of_pkgs' => $prnLr['total_num_of_pkgs'],
        'num_of_pkgs' => $prnLr['num_of_pkgs'],
        'remarks' => "PRN NO.$newprnNumber",
        'state_datetime' =>  date('Y-m-d H:i:s'), // Current date and time
        // 'state_change_by' => $prnLr['state_change_by']
    ];

        $this->pickupRequestNoteService->createPrnLrData($prnLrData);
        $this->pickupRequestNoteService->createFbLrStateLog($prnLrData);
        $this->pickupRequestNoteService->UpdateLr($prnLr['lr_id']); // Pass $prnLr['lr_id']
    }

   
    return response()->json(['message' => 'Data inserted successfully', 'prn_number' => $newprnNumber], 201);
}


public function fetchHVendor()
{
    $fetch_Hvendor = $this->pickupRequestNoteService->fetch_Hvendor();

    return response()->json($fetch_Hvendor, 200);
}




    public function show($id)
    {
        Log::debug("PickupRequestNote show method called in PickupRequestNoteController for ID: $id");
        $pickupRequestNote = $this->pickupRequestNoteService->getPickupRequestNoteById($id);
        if (! $pickupRequestNote) {
            Log::error("PickupRequestNote with ID: $id not found in PickupRequestNoteController@show");

            return response()->json(['message' => 'PickupRequestNote not found'], 404);
        }

        return response()->json($pickupRequestNote);
    }

    public function index(Request $request)
    {
        Log::debug('PickupRequestNote index method called in PickupRequestNoteController');

        try {
            $pickupRequestNotes = $this->pickupRequestNoteService->getAllPickupRequestNotes($request);

            if ($pickupRequestNotes->isEmpty()) {
                Log::info('No pickup request notes found in PickupRequestNoteController@index');
            }

            return response()->json($pickupRequestNotes);
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error in PickupRequestNoteController@index: '.$e->getMessage());

            // Return an error response
            return response()->json([
                'message' => 'Error fetching pickup request notes',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error
        }
    }

    public function update(PickupRequestNoteUpdateRequest $request, $id)
    {
        Log::debug("PickupRequestNote update method called in PickupRequestNoteController for ID: $id");
        $validatedData = $request->validated();
        $pickupRequestNote = $this->pickupRequestNoteService->updatePickupRequestNote($id, $validatedData);

        if (! $pickupRequestNote) {
            Log::error("PickupRequestNote with ID: $id not found in PickupRequestNoteController@update");

            return response()->json(['message' => 'PickupRequestNote not found'], 404);
        }

        return response()->json($pickupRequestNote);
    }

    public function deactivate($id)
    {
        Log::debug("Deactivating pickup request note with ID: $id in PickupRequestNoteController");
        $pickupRequestNote = $this->pickupRequestNoteService->deactivatePickupRequestNote($id);

        if ($pickupRequestNote) {
            Log::info("Pickup request note with ID: $id deactivated successfully");
            $response = $pickupRequestNote->toArray();
            $response['message'] = 'Pickup request note deactivated successfully';

            return response()->json($response, 200);
        }

        Log::error("Pickup request note with ID: $id not found for deactivation");

        return response()->json(['message' => 'Pickup request note not found'], 404);
    }

    public function destroy($id)
    {
        Log::debug("Attempting to delete pickup request note with ID: $id in PickupRequestNoteController");
        if ($this->pickupRequestNoteService->deletePickupRequestNote($id)) {
            Log::info("Pickup request note with ID: $id deleted successfully");

            return response()->json(['id' => $id, 'deleted' => true, 'message' => 'Pickup request note deleted successfully'], 200);
        }

        Log::error("Pickup request note with ID: $id not found for deletion");

        return response()->json(['id' => $id, 'message' => 'Pickup request note not found'], 404);
    }


// public function fetchLRNumbers(Request $request)
// {
//     Log::debug('Fetching all LR numbers in PickupRequestNoteController');
    
//     try {
//         // Fetch all LR numbers using the service method
//         $lrNumbers = $this->pickupRequestNoteService->fetchAllLRNumbers();

//         // Transform LR number IDs into an array of arrays
//         $formattedLRNumbers = [];
//         foreach ($lrNumbers as $lrNumber) {
//             $formattedLRNumbers[] = [$lrNumber]; // Assuming each LR number is an array by itself
//         }

//         return response()->json($formattedLRNumbers);
//     } catch (\Exception $e) {
//         // Log the exception
//         Log::error('Error fetching LR numbers: ' . $e->getMessage());
        
//         // Return an error response
//         return response()->json(['message' => 'Error fetching LR numbers', 'error' => $e->getMessage()], 500);
//     }
// }


public function fetchLRNumbers(Request $request)
{
    Log::debug('Fetching all LR numbers in PickupRequestNoteController');
    
    try {
        // Fetch all LR numbers using the service method
        $lrNumbers = $this->pickupRequestNoteService->fetchAllLRNumbers();

        // No need to transform LR numbers, return directly
        return response()->json($lrNumbers);
    } catch (\Exception $e) {
        // Log the exception
        Log::error('Error fetching LR numbers: ' . $e->getMessage());
        
        // Return an error response
        return response()->json(['message' => 'Error fetching LR numbers', 'error' => $e->getMessage()], 500);
    }
}





      public function selectcust($query)
    {
        Log::info('Cust show method called in Cust Controller');
        try {
            $cust = $this->pickupRequestNoteService->getcustbyname($query);
            return response()->json($cust);
        } catch (\Exception $e) {
            Log::error('Error fetching customer by name: ' . $e->getMessage());
            return response()->json(['message' => 'Customer not found'], 404);
        }

    }

        public function selectvehicle($query)
    {
        Log::info('vehicle show method called in vehicle Controller');
        try {
            $cust = $this->pickupRequestNoteService->getvehiclename($query);
            return response()->json($cust);
        } catch (\Exception $e) {
            Log::error('Error fetching vehicle by name: ' . $e->getMessage());
            return response()->json(['message' => 'vehicle not found'], 404);
        }

    }
    
    public function searchByDate(Request $request)
{
    Log::debug('Searching pickup request notes by date in PickupRequestNoteController');
    
    try {
        // Extracting parameters from the request
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        // Call the service method to fetch pickup request notes by date
        $pickupRequestNotes = $this->pickupRequestNoteService->searchByDate($fromDate, $toDate);

        return response()->json($pickupRequestNotes);
    } catch (\Exception $e) {
        // Log the exception
        Log::error('Error searching pickup request notes by date: ' . $e->getMessage());
        
        // Return an error response
        return response()->json(['message' => 'Error searching pickup request notes by date', 'error' => $e->getMessage()], 500);
    }
}

public function searchByPRN($prn)
{
    Log::debug('Searching pickup request notes by PRN in PickupRequestNoteController');
    
    try {
        // Call the service method to fetch pickup request notes by PRN
        $pickupRequestNotes = $this->pickupRequestNoteService->searchByPRN($prn);

        return response()->json($pickupRequestNotes);
    } catch (\Exception $e) {
        // Log the exception
        Log::error('Error searching pickup request notes by PRN: ' . $e->getMessage());
        
        // Return an error response
        return response()->json(['message' => 'Error searching pickup request notes by PRN', 'error' => $e->getMessage()], 500);
    }

}


public function searchprnarrival($prn)
{
    Log::debug('Searching pickup request notes by PRN in PickupRequestNoteController');
    
    try {
        // Call the service method to fetch pickup request notes by PRN
        $pickupRequestNotes = $this->pickupRequestNoteService->searchprnarrival($prn);

        return response()->json($pickupRequestNotes);
    } catch (\Exception $e) {
        // Log the exception
        Log::error('Error searching pickup request notes by PRN: ' . $e->getMessage());
        
        // Return an error response
        return response()->json(['message' => 'Error searching pickup request notes by PRN', 'error' => $e->getMessage()], 500);
    }
}

   


}