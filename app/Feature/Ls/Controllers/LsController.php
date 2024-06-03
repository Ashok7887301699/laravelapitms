<?php

namespace App\Feature\Ls\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Feature\Ls\Services\LsService;
use App\Feature\Lr\Repositories\LrRepositories;
use App\Feature\Ls\Models\Ls;
use App\Feature\Ls\Models\GetLrData;
use App\Feature\Ls\Models\LsLr;
use Illuminate\Support\Facades\Log;
use App\Feature\Ls\Requests\LsRequests;

class LsController extends Controller
{
    protected $LsService;

    public function __construct(LsService $LsService)
    {
        $this->LsService = $LsService;
    }



// public function store(LsRequests $request)
// {
//     $maxPRNNumber = Ls::max('id');
//     preg_match('/\d+$/', $maxPRNNumber, $matches);
//     $maxprnNumberNumericPart = isset($matches[0]) ? (int)$matches[0] : 0;
//     $newId = $maxprnNumberNumericPart + 1;
//     $newlsNumber = "LS/PNA/2425/" . str_pad($newId, 6, '0', STR_PAD_LEFT);

//     Log::debug('PickupRequestNote store method called in PickupRequestNoteController');
//     $validatedData = $request->validated();
//     Log::debug('Validated Data:', $validatedData);

//     $lsData = $validatedData;
//     $lsData['id'] = $newlsNumber;

//     // Create the LS record
//     $pickupRequestNote = $this->LsService->createLs($lsData);

//     // Handle ls_lr_data array
//     if (isset($validatedData['ls_lr_data']) && is_array($validatedData['ls_lr_data'])) {
//         // Access ls_lr_data from the nested object
//         $lsLrData = $validatedData['ls_lr_data'];

//         // Loop through each LR ID
//         foreach ($lsLrData as $lrId) {
//             // Create data for LS_LR record
//             $lslrData = [
//                 'ls_id' => $newlsNumber, // Set LS ID
//                 'lr_id' => $lrId, // Set LR ID
//             ];

//             // Create the LS_LR record for each LR ID
//             $this->LsService->createLsLrDetail($lslrData);
//         }
//     }


//     // Return response with message and PRN number
//     return response()->json(['message' => 'Data inserted successfully', 'prn_number' => $newlsNumber], 201);
// }



//Working Code
// public function store(LsRequests $request)
// {
//     $maxPRNNumber = Ls::max('id');
//     preg_match('/\d+$/', $maxPRNNumber, $matches);
//     $maxprnNumberNumericPart = isset($matches[0]) ? (int)$matches[0] : 0;
//     $newId = $maxprnNumberNumericPart + 1;
//     $newlsNumber = "LS/PNA/2425/" . str_pad($newId, 6, '0', STR_PAD_LEFT);

//     Log::debug('PickupRequestNote store method called in PickupRequestNoteController');
//     $validatedData = $request->validated();
//     Log::debug('Validated Data:', $validatedData);

//     $lsData = $validatedData;
//     $lsData['id'] = $newlsNumber;

//     // Create the LS record
//     $pickupRequestNote = $this->LsService->createLs($lsData);

//     // Handle ls_lr_data array
//     if (isset($validatedData['ls_lr_data']) && is_array($validatedData['ls_lr_data'])) {
//         // Access ls_lr_data from the nested object
//         $lsLrData = $validatedData['ls_lr_data'];

//         // Loop through each LR ID
//         foreach ($lsLrData as $lrData) {
//             // Ensure lr_id is a string
//             $lrId = $lrData['lr_id'];

//             // Create data for LS_LR record
//             $lslrData = [
//                 'ls_id' => $newlsNumber, // Set LS ID
//                 'lr_id' => $lrId, // Set LR ID
//             ];

//             // Create the LS_LR record for each LR ID
//             $this->LsService->createLsLrDetail($lslrData);
//         }
//     }

//     // Return response with message and PRN number
//     return response()->json(['message' => 'Data inserted successfully', 'prn_number' => $newlsNumber], 201);
// }
//Working Code End

//For Testing ls Genration

public function store(LsRequests $request)
{
    // Get the prefix from the frontend
    $prefix = $request->input('prefix');

    // Determine the current month code
    $currentMonth = date('M');
    $monthCode = $this->getMonthCode($currentMonth);

    // Determine the current finance year
    $currentYear = date('Y');
    $nextYear = $currentMonth >= 4 ? $currentYear + 1 : $currentYear;
    $financeYear = substr($nextYear, -2);

    // Get the depot code from the request or default to 'PNA'
    $depotCode = $request->input('depot_code', 'PNA');

    // Get the last LS ID for the given condition
    $lastLSId = $this->getLastLSId($prefix, $monthCode, $depotCode, $financeYear);

    // Increment the numeric part of the LS ID
    $newNumericPart = str_pad($lastLSId, 5, '0', STR_PAD_LEFT);

    // Generate the LS number
    $lsNumber = "LS$prefix$monthCode$depotCode$financeYear$newNumericPart";

    // Create LS record
    $validatedData = $request->validated();


    $lsData = $validatedData;
    $lsData['id'] = $lsNumber;
    $pickupRequestNote = $this->LsService->createLs($lsData);

    // Handle ls_lr_data array
    if (isset($validatedData['ls_lr_data']) && is_array($validatedData['ls_lr_data'])) {
        $lsLrData = $validatedData['ls_lr_data'];
        foreach ($lsLrData as $lrData) {
            $lrId = $lrData['lr_id'];
            $seqNum = $lrData['seq_num']; // Get the sequence number
            $lslrData = [
                'ls_id' => $lsNumber,
                'lr_id' => $lrId,
                'seq_num' => $seqNum,
                'tenant_id' => 1,
            ];
            $this->LsService->createLsLrDetail($lslrData);
        }
    }

    // Return response with message and LS number
    return response()->json(['message' => 'Data inserted successfully', 'ls_number' => $lsNumber], 201);
}

// Function to get the last LS ID for the given condition
private function getLastLSId($prefix, $monthCode, $depotCode,  $financeYear)
{
    $lsPrefix = "LS$prefix$monthCode$depotCode$financeYear";
    $lastLS = Ls::where('id', 'like', "$lsPrefix%")->latest()->first();

    if ($lastLS) {
        $lastIdNumericPart = intval(substr($lastLS->id, -5));
        return $lastIdNumericPart + 1;
    } else {
        return 1; // If no LS exists yet, start with 1
    }
}


// Function to get the month code based on the month abbreviation
private function getMonthCode($monthAbbreviation)
{
    $monthCodes = [
       'Apr' => 'A', 'May' => 'B', 'Jun' => 'C',
        'Jul' => 'C', 'Aug' => 'E', 'Sep' => 'F',
        'Oct' => 'G', 'Nov' => 'H', 'Dec' => 'I',
         'Jan' => 'J', 'Feb' => 'K', 'Mar' => 'L',
    ];

    return $monthCodes[$monthAbbreviation] ?? '';
}





//end testing

    public function getlrdata($query)
    {

        Log::info('Lr show method called in Drs Controller');
        try {
            $lr = $this->LsService->getlrby($query);
            return response()->json($lr);
        } catch (\Exception $e) {
            Log::error('Error fetching lr by name: ' . $e->getMessage());
            return response()->json(['message' => 'lr not found'], 404);
        }
    }

    public function getLrDetailsById($query)
    {
        try {
            $lrDetails = $this->LsService->getLrDetailsByIdWithJoin($query);

            if (!$lrDetails) {
                return response()->json(['message' => 'LR not found'], 404);
            }

            return response()->json($lrDetails);
        } catch (\Exception $e) {
            Log::error('Error fetching LR details: ' . $e->getMessage());
            return response()->json(['message' => 'Error fetching LR details'], 500);
        }
    }
}
