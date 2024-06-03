<?php

namespace App\Feature\Lr\Controllers;

use App\Http\Controllers\Controller;
use App\Feature\Lr\Requests\LrStoreRequest;
use App\Feature\Lr\Services\LrService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Feature\Lr\Models\lrdata;


class LrController extends Controller
{
    protected $lrService;

    public function __construct(LrService $lrService)
    {
        $this->lrService = $lrService;
    }       
    public function store(Request $request)
    {
        $maxLRNumber = lrdata::max('id');
        preg_match('/\d+$/', $maxLRNumber, $matches);
        $maxLRNumberNumericPart = isset($matches[0]) ? (int)$matches[0] : 0;
       
        // Add leading zeros to make it 10 digits long
        $newId = str_pad($maxLRNumberNumericPart + 1, 10, '0', STR_PAD_LEFT);
       
        $newLRNumber = "PNA$newId";
        
        $lrData = [
            "id"=>$newLRNumber,
            "tenant_id" => 1,
            "booking_user_id" => 1,
            "consignor_id" => $request->input('consignor_id'),
            "consignor_name" =>$request->input('wcon_name'),
             "consignor_addr"=>$request->input('conadd'),
             "consignor_gst"=>$request->input('gstno'),
             "consignee_gst"=>$request->input('gstno_con'),
            "consignor_mobile" => $request->input('MobileNo'),
            "freight_rate_per_kg" => $request->input('frtrate'),
            "total_freight_charges" => $request->input('frtcharge'),
            "insurance_rate" => $request->input('inscharge'),
            "other_charges"=>$request->input('codcharge'),
              "docu_charges"=>$request->input('doccharge'),
              "excess_weight_charges"=>$request->input('excescharge'),
              "truck_load_type"=>$request->input('truck_load_type'),
              "del_speed"=>$request->input('del_speed'),
              "pickup_del_type"=>$request->input('pickup_del_type'),
              "freight_rate_type"=>$request->input('freight_rate_type'),
              "door_del_charges"=>$request->input('doorcharge'),
              "sgst_amnt"=>$request->input('gstcharge'),
              "oda_charges"=>$request->input('odacharge'),
            "payment_type" => $request->input('payment_type'),
            "consignee_type" =>"NONE",
            "consignee_id" => $request->input('consignor_id'),
            "consignee_name" =>$request->input('con_name'),
            "consignee_mobile" =>$request->input('MobileNo_con'),
            "cost_center_id" => '',
            "from_place" => $request->input('from_place'),
            "to_place" => $request->input('to_place'),
            "status" => "PNA",
            "edited_by" => "1",
            "canceled_by" => 1,
            "return_booked_by" => 1,
           
 
        ];
    
        $lr = $this->lrService->createLr($lrData);
        if (!$lr) {
            return response()->json(['message' => 'Failed to create LR'], 500);
        }
   
        // Group added items by invoice number
        $groupedItems = collect($request->input('addedItems'))->groupBy('Invoiceno');
   
        foreach ($groupedItems as $invoiceNo => $items) {
            foreach ($items as $item) {
                $consignmentData = [
                    "tenant_id" => 1,
                    "lr_id" => $newLRNumber, // Use the LR number generated earlier
                    "invoice_num" => $item['Invoiceno'],
                    "invoice_date" => $item['Invoicedate'],
                    "pkg_type" => $item['Packaging_type'],
                    "Product_type" => $item['Product_type'],
                    "invoice_value" => $item['invoicegrossval'],
                    "num_of_pkgs" => $item['noofpkg'],
                    "actual_weight_per_pkg" => $item['akcwtperpkg'],
                    "total_actual_weight" => $item['akcwt'],
                ];
   
                // Insert into fb_consignment table using the same function
                $consignment = $this->lrService->createLradd($consignmentData);
   
                if (!$consignment) {
                    return response()->json(['message' => 'Failed to create consignment'], 500);
                }
            }
        }
   
        return response()->json(['message' => 'LR and consignments created successfully', 'lr' => $lrData], 201);
    }
    public function show()
    {
        try {
            $paymodel = $this->lrService->fetchpaymodel();
            return response()->json(['paymodel' => $paymodel], 200);
        } catch (\Exception $e) {
            // Log any errors
            Log::error('Error fetching pay models: ' . $e->getMessage());
            // Return error response
            return response()->json(['message' => 'An error occurred while fetching pay models'], 500);
        }
    }
    public function getdata()
    {
        try {
            $PackageModel = $this->lrService->fetchPackageModels();
            return response()->json(['packageModels' => $PackageModel], 200);
        } catch (\Exception $e) {
            // Log any errors
            Log::error('Error fetching pay models: ' . $e->getMessage());
            // Return error response
            return response()->json(['message' => 'An error occurred while fetching pay models'], 500);
        }
    }
     public function getpro()
    {
        try {
            $productModels = $this->lrService->fetchProductModels();
            return response()->json(['productModels' => $productModels], 200);
        } catch (\Exception $e) {
            // Log any errors
            Log::error('Error fetching pay models: ' . $e->getMessage());
            // Return error response
            return response()->json(['message' => 'An error occurred while fetching pay models'], 500);
        }
    }
    // public function getcontract()
    // {
    //     try {
    //         $lrcontractModels = $this->lrService->fetchcontractModels();
    //         return response()->json(['productModels' => $lrcontractModels], 200);
    //     } catch (\Exception $e) {
    //         // Log any errors
    //         Log::error('Error fetching pay models: ' . $e->getMessage());
    //         // Return error response
    //         return response()->json(['message' => 'An error occurred while fetching pay models'], 500);
    //     }
    // }

    //np changes
    // public function selectcust($query)
    // {
    //     Log::info('Cust show method called in Cust Controller');
    //     try {
    //         $cust = $this->lrService->getcustbyname($query);
    //         return response()->json($cust);
    //     } catch (\Exception $e) {
    //         Log::error('Error fetching customer by name: ' . $e->getMessage());
    //         return response()->json(['message' => 'Customer not found'], 404);
    //     }     
    // }
    public function selectcust($query,$paytype)
    {
        Log::info('Cust show method called in Cust Controller');
        try {
            $cust = $this->lrService->getcustbynameWithPayType($query,$paytype);
            return response()->json($cust);
        } catch (\Exception $e) {
            Log::error('Error fetching customer by name: ' . $e->getMessage());
            return response()->json(['message' => 'Customer not found'], 404);
        }
    }
    public function selectcont( $consignor_id)
    {
        Log::info('Select contract method called in LrController');
        try {
            $contracts = $this->lrService->getcontractidWithPayType($consignor_id);
            return response()->json($contracts);
        } catch (\Exception $e) {
            Log::error('Error fetching contracts: ' . $e->getMessage());
            return response()->json(['message' => 'Error fetching contracts'], 500);
        }
    }
    // public function selectcontslabrate( $consignor_id)
    // {
    //     Log::info('Select contract method called in LrController');
    //     try {
    //         $contract_slab_rates = $this->lrService->getcontslabrateWithPayType($contract_id);
    //         return response()->json($contract_slab_rates);
    //     } catch (\Exception $e) {
    //         Log::error('Error fetching contracts: ' . $e->getMessage());
    //         return response()->json(['message' => 'Error fetching contracts'], 500);
    //     }
    // }
    public function selectcontslabrate($consignor_id)
{
    Log::info('Select contract method called in LrController');
    try {
        $fromPlace = $this->lrService->getcontractslabrate($consignor_id);
        return response()->json($fromPlace);
    } catch (\Exception $e) {
        Log::error('Error fetching from place: ' . $e->getMessage());
        return response()->json(['message' => 'Error fetching from place'], 500);
    }
}

public function selectContractSlabDefinition($contract_id, $Invoicenoofpkg)
    {
        try {
            // Fetch all slab definitions based on the provided contract_id
            $slabDefinitions = $this->lrService->getSlabRateDefinitions($contract_id);

            // Iterate through each slab definition
            foreach ($slabDefinitions as $slabDefinition) {
                // Check if Invoicenoofpkg falls within the slab limits
                if ($Invoicenoofpkg >= $slabDefinition->slab_lower_limit && $Invoicenoofpkg <= $slabDefinition->slab_upper_limit) {
                    // Get the slab rate based on the contract_id and slab_number
                    $slabRate = $this->lrService->getSlabRate($contract_id, $slabDefinition->slab_number);

                    // Return success response
                    return response()->json([
                        'slabDefinition' => $slabDefinition,
                        'slabRate' => $slabRate
                    ]);
                }
            }

            // If Invoicenoofpkg is outside all slab limits, return error response
            return response()->json([
                'message' => 'Invoice number of packages is outside the slab limits for contract ' . $contract_id
            ], 400); // 400 Bad Request status code
        } catch (\Exception $e) {
            // If an exception occurs, return error response
            return response()->json([
                'message' => $e->getMessage()
            ], 500); // 500 Internal Server Error status code
        }
    }




public function selectContractSlabrate($contract_id, $slab_number)
{
    // Assuming $this->lrService is an instance of your LRService class
    $slabRate = $this->lrService->getSlabRate($contract_id, $slab_number);
    
    return $slabRate;
}

// public function selectContractSlabDefinition($consignor_id)
// {
//     Log::info('Select contract method called in LrController');
//     try {
//         $slab_contract_type = $this->lrService->getSlabRateDefinition($consignor_id);
//         return response()->json($slab_contract_type);
//     } catch (\Exception $e) {
//         Log::error('Error fetching from place: ' . $e->getMessage());
//         return response()->json(['message' => 'Error fetching from place'], 500);
//     }
// }




// public function fetchratetype($contract_id)
// {
//     Log::info('Fetch rate type method called in LrController');
//     try {
//         $rateType = $this->contractService->getSlabRateType($contract_id);
//         return response()->json(['rate_type' => $rateType]);
//     } catch (\Exception $e) {
//         Log::error('Error fetching rate type: ' . $e->getMessage());
//         return response()->json(['message' => 'Error fetching rate type'], 500);
//     }
// }

    public function fetchPickDel( $consignor_id)
    {
        Log::info('Select contract method called in LrController');
        try {
            $contracts = $this->lrService->getPickDelFromConractId($consignor_id);
            return response()->json($contracts);
        } catch (\Exception $e) {
            Log::error('Error fetching contracts: ' . $e->getMessage());
            return response()->json(['message' => 'Error fetching contracts'], 500);
        }
    }
    

    

    
    public function selectfromcity($query)
    {
        Log::info('city show method called in city Controller');
        try {
            $fcity = $this->lrService->getfromcity($query);
            return response()->json($fcity);
        } catch (\Exception $e) {
            Log::error('Error fetching from city name: ' . $e->getMessage());
            return response()->json(['message' => 'city not found'], 404);
        }

    }
    public function selecttocity($query)
    {
        Log::info('city show method called in city Controller');
        try {
            $fcity = $this->lrService->gettocity($query);
            return response()->json($fcity);
        } catch (\Exception $e) {
            Log::error('Error fetching To city name: ' . $e->getMessage());
            return response()->json(['message' => 'city not found'], 404);
        }

    }
    // public function getdata()
    // {
    //     try {
    //         $PackageModel = $this->lrService->fetchPackageModels();
    //         return response()->json(['packageModels' => $PackageModel], 200);
    //     } catch (\Exception $e) {
    //         // Log any errors
    //         Log::error('Error fetching pay models: ' . $e->getMessage());
    //         // Return error response
    //         return response()->json(['message' => 'An error occurred while fetching pay models'], 500);
    //     }
    // }
    //  public function getpro()
    // {
    //     try {
    //         $productModels = $this->lrService->fetchProductModels();
    //         return response()->json(['productModels' => $productModels], 200);
    //     } catch (\Exception $e) {
    //         // Log any errors
    //         Log::error('Error fetching pay models: ' . $e->getMessage());
    //         // Return error response
    //         return response()->json(['message' => 'An error occurred while fetching pay models'], 500);
    //     }
    // }
  
    public function getLrData(Request $request, $customLrNum)
{
    $data = $this->lrService->fetchLrData($customLrNum);
    return response()->json($data);
}

public function fblrdata(Request $request, $customLrNum)
{
    $data = $this->lrService->fbfetchLrData($customLrNum);
    return response()->json($data);
}

}
