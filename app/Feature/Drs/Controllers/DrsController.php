<?php


namespace App\Feature\Drs\Controllers;


use App\Feature\Drs\Requests\DrsStoreRequest;
use App\Feature\Drs\Services\DrsService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Feature\Drs\Models\Vendordata;
use App\Feature\Drs\Models\Vehicledata;
use App\Feature\Drs\Models\Driverdata;
use App\Feature\Drs\Models\Lrdata;
use App\Feature\Drs\Models\GetLsdata;
use App\Feature\Drs\Models\Drs;
use App\Feature\Drs\Models\Drsdata;
use App\Feature\Drs\Models\Hamalidata;
use App\Feature\Drs\Models\Ls;
use App\Feature\Drs\Models\LsLr;
use App\Feature\Drs\Models\DrsLr;
use App\Feature\Drs\Models\vehiclecapacitymodel;
use App\Feature\Drs\Models\Verify_POD;



class DrsController extends Controller
{
    protected $drsService;


    public function __construct(DrsService $drsService)
    {
        $this->drsService = $drsService;
    }


    public function getdata()
{
    Log::info('Attempting to get driver names'); 
    $uniqueDriverNames = $this->drsService->getDriverNames();
    Log::info('Driver names retrieved: ' . json_encode($uniqueDriverNames)); 

    return response()->json($uniqueDriverNames);
}


public function getcapacity()
{
    Log::info('Attempting to get capacity models'); 
    $capacitymodeldata = $this->drsService->getUniqueCapacityNames();
    Log::info('Capacity models retrieved: ' . json_encode($capacitymodeldata));

    return response()->json($capacitymodeldata);
}


    public function getAttachedVendors()
    {
        $attachedVendors = $this->drsService->getAttachedVendorCodeandName();
        return response()->json($attachedVendors);
    }


    public function gethamali()
    {
        $hamaliVendors = $this->drsService->gethamaliname();
        return response()->json($hamaliVendors);

    }

    public function getfuelname(){
        $fuelname = $this->drsService->getFuelname();
        return response()->json($fuelname);
    }

    public function show()
    {
        $attachedVendorsName = $this->drsService->getAttachedVendorname();
        return response()->json($attachedVendorsName);
    }


    public function getVehicleNos(Request $request, $vendorName)
    {
        if (!$vendorName) {
            return response()->json(['error' => 'Vendor name is required'], 400);
        }

        $vehicleNos = Vehicledata::getVehicleNoByVendorName($vendorName);
        return response()->json($vehicleNos);
    }

    public function getlsdata($query)
    {
    
        Log::info('Ls show method called in Drs Controller');
        try {
            $ls = $this->drsService->getlsby($query);
            return response()->json($ls);
        } catch (\Exception $e) {
            Log::error('Error fetching lr by name: ' . $e->getMessage());
            return response()->json(['message' => 'lr not found'], 404);
        }
    }


    public function autocomplete($query)
    {
    
        Log::info('Lr show method called in Drs Controller');
        try {
            $drs = $this->drsService->getdrsid($query);
            return response()->json($drs);
        } catch (\Exception $e) {
            Log::error('Error fetching drs by DRSno: ' . $e->getMessage());
            return response()->json(['message' => 'DRSno not found'], 404);
        }
    }


    public function getdrsdata(Request $request, $id)
    {
        if (!$id) {
            return response()->json(['error' => 'Drs data is required'], 400);
        }

        $drsdata = $this->drsService->getDrsnobydata($id);

        
        if ($drsdata) {
            return response()->json($drsdata);
        } else {
            // If Drsdata is not found, return appropriate response
            return response()->json(['error' => 'Drs data not found'], 404);
        }
    }

    public function fetchByNumber($query)
    {
        try {
            $lsDetails = $this->drsService->getByNumber($query);

            if (!$lsDetails) {
                return response()->json(['message' => 'Ls not found'], 404);
            }

            return response()->json($lsDetails);
        } catch (\Exception $e) {
            Log::error('Error fetching LR details: ' . $e->getMessage());
            return response()->json(['message' => 'Error fetching LR details'], 500);
        }
    }


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


    public function store(DrsStoreRequest $request)
{
    Log::info('Drs store method called in DrsController');

    $maxDrsNumber = Drs::max('id');

    preg_match('/\d+$/', $maxDrsNumber, $matches);
    $maxDrsNumberNumericPart = isset($matches[0]) ? (int)$matches[0] : 0;
    $newId = $maxDrsNumberNumericPart + 1;

    $monthLetter = chr(65 + intval(date('n') - 1)); 
    $yearDigits = date('y');
    $vendorTypeLetter = $request->attached ? 'H' : 'O';
    $newDrsNumber = "D{$vendorTypeLetter}APNA{$yearDigits}" . str_pad($newId, 7, '0', STR_PAD_LEFT);
    $validatedData = $request->validated();

    $validatedData['id'] = $newDrsNumber;

    $drsRequestNote = $this->drsService->createDrsData($validatedData);

    foreach ($validatedData['drs_data'] as $drsLr) {
        $data = [
            'drs_id' => $newDrsNumber,
            'tenant_id' => $drsLr['tenant_id'],
            'lr_id' => $drsLr['lr_id'], 
        ];
        $this->drsService->createDrsLrData($data);
    }

    return response()->json(['message' => 'Data inserted successfully', 'drs_id' => $newDrsNumber], 201);
}



   
    


    
 
 

}
