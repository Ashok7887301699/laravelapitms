<?php

namespace App\Feature\Lr\Services;

use Illuminate\Support\Facades\Log;
use App\Feature\Lr\Repositories\LrRepositories;
use Illuminate\Http\Request;
use App\Feature\Lr\Models\paymodel;
use App\Feature\Lr\Models\packagemodel;
use App\Feature\Lr\Models\productModel;
use App\Feature\Lr\Models\lrcontractModel;
use App\Feature\Contract\Models\Contract;
use App\Feature\Contract\Models\ContractSlabRate;
use App\Feature\Contract\Models\ContractSlabDefinition;



use App\Feature\PickupRequestNote\Models\Customer;
use App\Feature\citymaster\Models\citymaster;
use App\Feature\Lr\Models\lrdata;
use App\Feature\Lr\Models\lrfetchdata;
use App\Feature\Lr\Models\fb_lrfetchdata;
use App\Feature\Lr\Models\lrdatamultiple;

use App\Feature\Contract\Models\ContractServices;

class LrService
{

    protected $lrRepositories;

    public function __construct(LrRepositories $lrRepositories)
    {
        $this->lrRepositories = $lrRepositories;
    }
    public function createLr($data)
    {
        // Log or dump the $data array to see its contents
        Log::info('Data received for LR creation: ' . json_encode($data));
    
        // Attempt to create the LR record
        $lr = lrdata::create($data);
        return $lr; // Don't forget to return the created instance
    }
    
    public function createLradd($data)
    {
        // Log or dump the $data array to see its contents
        Log::info('Data received for LR creation: ' . json_encode($data));
    
        // Attempt to create the LR record
        $lr = lrdatamultiple::create($data);
        return $lr; // Don't forget to return the created instance
    }
    public function fetchLrData($customLrNum)
    {
        return lrfetchdata::where('lr_id', $customLrNum)->get();
    }
    
    public function fbfetchLrData($customLrNum)
    {
        return fb_lrfetchdata::where('id', $customLrNum)->get();
    }
    
    public function fetchpaymodel()
    {
        $paymodel = PayModel::groupBy('contract_paymenttype')->pluck('contract_paymenttype')->toArray();
        return $paymodel;
    }
    public function fetchPackageModels()
    {
        try {
            $packageModels = PackageModel::pluck('package_type')->toArray();
            return $packageModels;
        } catch (\Exception $e) {
            \Log::error('Error fetching package models: ' . $e->getMessage());
            return []; // Return an empty array if there's an error
        }
    }
    public function fetchProductModels()
    {
        try {
            $productModels = productModel::pluck('product_type')->toArray();
            return $productModels;
        } catch (\Exception $e) {
            \Log::error('Error fetching product models: ' . $e->getMessage());
            return []; // Return an empty array if there's an error
        }
    }
    public function fetchcontractModels()
    {
        try {
            $lrcontractModels = lrcontractModel::pluck('sap_cust_code')->toArray();
            return $lrcontractModels;
        } catch (\Exception $e) {       
            \Log::error('Error fetching product models: ' . $e->getMessage());
            return []; // Return an empty array if there's an error
        }
    }
    // np changes
    // public function getcustbyname($query)
    // {
        
    //     return Customer::where('CustName', 'like', '%' . $query . '%')
    //                    ->orWhere('sap_cust_code', 'like', '%' . $query . '%')
    //                    ->select('CustName', 'sap_cust_code')
    //                    ->get();
    // }

    public function getcustbynameWithPayType($query,$paytype)
    {
        return Customer::where(function($queryBuilder) use ($query) {
                    $queryBuilder->where('CustName', 'like', '%' . $query . '%')
                                 ->orWhere('sap_cust_code', 'like', '%' . $query . '%');
                })
                ->where('Category', $paytype)
                ->select('CustName', 'sap_cust_code')
                ->get();
    }




    public function getcontractslabrate($contract_id)
    {
        return ContractSlabRate::where('contract_id', $contract_id)
                                ->first(['contract_id','from_place', 'to_place']);
    }

    public function getSlabRateDefinitions($contract_id)
    {
        // Fetch all slab definitions based on contract_id
        $slabDefinitions = ContractSlabDefinition::where('contract_id', $contract_id)
            ->get(['contract_id', 'slab_number', 'slab_lower_limit', 'slab_upper_limit', 'slab_rate_type']);

        // Check if any slab definition is found
        if ($slabDefinitions->isEmpty()) {
            throw new \Exception('No slab definitions found for contract ' . $contract_id);
        }

        // Return slab definitions
        return $slabDefinitions;
    }

    // Other methods in your LrService class

        public function getSlabRate($contract_id, $slab_number)
        {
            // Construct the column name dynamically
            $slabColumnName = 'slab'.$slab_number;
        
            // Assuming ContractSlabRate is your model for the contract_slab_rates table
            $slabRate = ContractSlabRate::where('contract_id', $contract_id)
                ->value($slabColumnName);
        
            return $slabRate;
        }
    
    
    


    // public function getSlabRateType($contract_id)
    // {
    //     try {
    //         // Fetch the contract slab definition
    //         $contractSlabDefinition = ContractSlabDefinition::where('contract_id', $contract_id)->first();

    //         if (!$contractSlabDefinition) {
    //             return null; // Or handle the case where the contract slab definition doesn't exist
    //         }

    //         // Return the slab rate type
    //         return $contractSlabDefinition->slab_rate_type;
    //     } catch (\Exception $e) {
    //         Log::error('Error fetching slab rate type: ' . $e->getMessage());
    //         throw $e; // Rethrow the exception to handle it in the controller
    //     }
    // }

    public function getcontractidWithPayType($contract_id)
    {
        // Fetch the contract from the Contract table
        $contract = Contract::where('sap_cust_code', $contract_id)->first();
    
        if (!$contract) {
            return null; // Or handle the case where the contract doesn't exist
        }
    
        // Fetch the corresponding load_type from the SlabService table
        $slabService = ContractServices::where('contract_id', $contract->contract_id)->first();
    
        if (!$slabService) {
            return null; // Or handle the case where the slab_service entry doesn't exist
        }
    
        // Log the contract_id
        \Log::info('Contract ID: ' . $contract->contract_id);
    
        // Return the load_type value along with contract_id
        return [
            'contract_id' => $contract->contract_id,
            'load_type' => $slabService->load_type
        ];
    }
    

public function getPickDelFromConractId($contract_id)
{
    // Fetch the contract from the Contract table
    $contract = Contract::where('sap_cust_code', $contract_id)->first();

    if (!$contract) {
        return null; // Or handle the case where the contract doesn't exist
    }

    // Fetch the corresponding load_type from the SlabService table
    $slabService = ContractServices::where('contract_id', $contract->contract_id)->first();

    if (!$slabService) {
        return null; // Or handle the case where the slab_service entry doesn't exist
    }

    // Return the load_type value
    return $slabService->pickup_delivery_mode;
}

public function getcontratslabdefin($contract_id, $Invoicenoofpkg){


}


    public function getfromcity($query)
{
    return citymaster::where('CityNameEng', 'like', '%' . $query . '%')
                   ->select('CityNameEng')
                   ->get();
}
public function gettocity($query)
{
    return citymaster::where('CityNameEng', 'like', '%' . $query . '%')
                   ->select('CityNameEng')
                   ->get();
}

    
}
