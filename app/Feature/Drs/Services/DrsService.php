<?php


namespace App\Feature\Drs\Services;


use App\Feature\Drs\Models\Drsdata;
use App\Feature\Drs\Models\Vendordata;
use App\Feature\Drs\Models\Vehicledata;
use App\Feature\Drs\Models\Driverdata;
use App\Feature\Drs\Models\Lrdata;
use App\Feature\Drs\Models\GetLsdata;
use App\Feature\Drs\Models\DrsLr;
use App\Feature\Drs\Models\Ls;
use App\Feature\Drs\Models\LsLr;
use App\Feature\Drs\Models\Drs;
use App\Feature\Drs\Models\Capacitydata;
use App\Feature\Drs\Models\FuelVendordata;
use App\Feature\Drs\Models\Hamalidata;
use App\Feature\Drs\Models\Verify_POD;

use App\Feature\Drs\Repositories\DrsRepository;


class DrsService
{
    protected $drsRepository;


    public function __construct(DrsRepository $drsRepository)
    {
        $this->drsRepository = $drsRepository;
    }


    public function createDrsData(array $data)
    {
        return $this->drsRepository->create($data);
    }
    
    public function createDrsLrData(array $data)
    {
        return DrsLr::create($data);
    }

    


    public function getAttachedVendorCodeandName()
    {
        $attachedVendors = Vendordata::attached()->get(['VendorCode', 'VendorName']);
        return $attachedVendors;
    }

    public function gethamaliname()
    {
        $hamaliVendors = Hamalidata::get(['VendorCode', 'Hvendor']);
        return $hamaliVendors;
    }

    public function getFuelname(){
        $fuelname = FuelVendordata::get(['PetrolPumpName']);
        return $fuelname;
    }


    public function getAttachedVendorname()
    {
        $attachedVendorsname = Vehicledata::pluck('VendorName')->unique()->toArray();
        return $attachedVendorsname;
    }


    public function getVehicleNoByVendorName($vendorName)
    {
        $vehicleNos = Vehicledata::where('VendorName', $vendorName)->pluck('Vehicle_No')->toArray();
        return $vehicleNos;
    }


    public function getDriverNames()
{
    $drivers = Driverdata::all();
        
        $fullNames = $drivers->map(function ($driver) {
            return $driver->full_name; 
        });
        
        return $fullNames->toArray();
}


    public function getUniqueCapacityNames()
    {
        $capacitymodeldata = Capacitydata::pluck('vehcpctmodel')->unique('vehcpctmodel')->toArray();
        return $capacitymodeldata;
    }

    public function getlsby($query)
    {
        
        return GetLsdata::where('id', 'like', '%' . $query . '%')
        ->where(function ($query) {
            $query->where('status', 1)
                  ->orWhere('status', 6);
        })
                       ->select('id')
                       ->get();
    }


    public function getdrsid($query)
{
    return Verify_POD::where('id', 'like', '%' . $query . '%')
                     ->selectRaw('id')
                     ->get();
}

public function getDrsnobydata($id)
{
    try {
        // Retrieve the DRSNO values first
        $drsnoData = Drsdata::select(
            'ff_pod.verified as verified',
            'ff_pod.pod_artefact_url as pod_artefact_url',
            'ff_pod.drs_id as DRSNO',
            'ff_pod.consignor_id as consignor_id',
            'ff_pod.delivered as delivered',
            'ff_pod.del_datetime as del_datetime',
            'customers.CustName as CustName',
            'fb_lr.to_place as place',
            'fb_lr.total_num_of_pkgs as total_num_of_pkgs',
            'fb_lr.consignee_name as consignee_name',
            'fb_lr.id as LRNO',

            'fb_lr.delivered_at as delivered_at'
        )
        ->leftJoin('ff_pod', 'fm_drs.id', '=', 'ff_pod.drs_id')
        ->leftJoin('fb_lr', 'fb_lr.id', '=', 'ff_pod.lr_id') // Corrected join condition
        ->leftJoin('customers', 'customers.sap_cust_code', '=', 'ff_pod.consignor_id')
        ->where('fm_drs.id', $id)
        ->get();
    

        if ($drsnoData->isEmpty()) {
            \Log::error("No DRSNO data found for id: $id");
            return response()->json(['error' => 'DRSNO data not found'], 404);
        }

        // Retrieve the related data
        $relatedData = Drsdata::select('fm_drs.*', 'Vendor.VendorName')
            ->leftJoin('Vendor', 'fm_drs.fleet_vendor_id', '=', 'Vendor.VendorCode')
            ->where('fm_drs.id', $id)
            ->first();

        if (!$relatedData) {
            \Log::error("Drsdata not found for id: $id");
            return response()->json(['error' => 'Drsdata not found'], 404);
        }

        // Organize data into desired format
        $formattedData = [
            'id' => $relatedData->id,
            'tenant_id' => $relatedData->tenant_id,
            'dated' => $relatedData->dated,
            'vehicle_num' => $relatedData->vehicle_num,
            'del_depot' => $relatedData->del_depot,
            'driver_mobile' => $relatedData->driver_mobile,
            'driver_name' => $relatedData->driver_name,
            'fleet_vendor_id' => $relatedData->fleet_vendor_id,
            'vendor_name' => $relatedData->VendorName,
            'drsno_data' => $drsnoData->toArray(),
        ];

        return response()->json($formattedData, 200);
    } catch (\Exception $e) {
        \Log::error("Error fetching Drsdata: {$e->getMessage()}");
        return response()->json(['error' => 'An error occurred while fetching data'], 500);
    }
}


public function getByNumber($query)
{
    try {
        $lsDetails = GetLsdata::join('fm_ls_lr', 'fm_ls.id', '=', 'fm_ls_lr.ls_id')
            ->select(
                'fm_ls_lr.ls_id',
                'fm_ls.from_depot',
                'fm_ls.to_depot',
                'fm_ls.dated',
                'fm_ls.total_weight',
                'fm_ls.actual_box_weight',
                'fm_ls.total_bag_qty',
                'fm_ls.total_topay',
                'fm_ls.actual_bag_weight',
                'fm_ls.total_box_qty',
                'fm_ls.freight_charges',
                'fm_ls_lr.seq_num',
                'fm_ls_lr.lr_id'
            )
            ->where('fm_ls_lr.ls_id', $query)
            ->first();
    
        if ($lsDetails) {
            return $lsDetails;
        } else {
            return response()->json(['message' => 'No LR details found for the provided ID.'], 404);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error fetching LR details: ' . $e->getMessage()], 500);
    }
}

}
