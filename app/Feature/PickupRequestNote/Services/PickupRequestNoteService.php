<?php

namespace App\Feature\PickupRequestNote\Services;

use App\Feature\PickupRequestNote\Models\PickupRequestNote;
use App\Feature\PickupRequestNote\Models\fm_loader_expense;
use App\Feature\PickupRequestNote\Repositories\PickupRequestNoteRepository;
use Illuminate\Support\Facades\Log;
use App\Feature\PickupRequestNote\Models\Customer;

use App\Feature\PickupRequestNote\Models\PrnLrModel;
use App\Feature\PickupRequestNote\Models\fb_lr_state_log;

use App\Feature\Vehicle\Models\Vehicle;
use App\Feature\Hamali\Models\Hamali;
use App\Feature\Lr\Models\lrdata;
use App\Feature\Lr\Models\lrdatamultiple;


class PickupRequestNoteService
{
    protected $pickupRequestNoteRepository;

    public function __construct(PickupRequestNoteRepository $pickupRequestNoteRepository)
    {
        $this->pickupRequestNoteRepository = $pickupRequestNoteRepository;
    }

 public function createPickupRequestNote(array $data)
{
    return $this->pickupRequestNoteRepository->create($data);
}

public function createLoaderExpense(array $data)
{
    return fm_loader_expense::create($data);
}

public function createPrnLrData(array $data)
{
    return PrnLrModel::create($data);
}

public function createFbLrStateLog(array $data)
{
    return fb_lr_state_log::create($data);
}


public function fetch_Hvendor()
{
    return Hamali::select('id', 'Hvendor')->groupBy('id', 'Hvendor')->get();
}
    
   public function getPickupRequestNoteById($id)
{
    Log::debug("Fetching PickupRequestNote with ID: $id in PickupRequestNoteService");

    return $this->pickupRequestNoteRepository->find($id);
}



     public function getAllPickupRequestNotes($request)
    {
        Log::debug('Fetching list of PRN in prn Service', ['query_params' => $request->query()]);
        $query = PickupRequestNote::query();

        // Filter by 'name'
        if ($request->has('id')) {
            $query->where('id', 'like', '%'.$request->id.'%');
        }

        // Filter by 'short_name'
        if ($request->has('vehicle_num')) {
            $query->where('vehicle_num', 'like', '%'.$request->vehicle_num.'%');
        }

        if ($request->has('hamalivendoramount')) {
            $query->where('hamalivendoramount', 'like', '%'.$request->hamalivendoramount.'%');
        }
    

        
        if ($request->has(['created_from', 'created_to'])) {
            $query->whereBetween('created_at', [$request->created_from, $request->created_to]);
        }

        
        if ($request->has(['updated_from', 'updated_to'])) {
            $query->whereBetween('updated_at', [$request->updated_from, $request->updated_to]);
        }

      
        $query->orderBy($request->get('sort_by', 'updated_at'), $request->get('sort_order', 'desc'));

   
        $perPage = $request->get('per_page', 10); 

        return $query->paginate($perPage);
    }

    public function updatePickupRequestNote($id, array $data)
    {
        Log::debug('Updating PickupRequestNote in PickupRequestNoteService', ['id' => $id, 'data' => $data]);
        $pickupRequestNote = $this->pickupRequestNoteRepository->find($id);
        if ($pickupRequestNote) {
            $pickupRequestNote->update($data);

            return $pickupRequestNote;
        }

        Log::error('PickupRequestNote not found for update', ['id' => $id]);

        return null;
    }

    public function deactivatePickupRequestNote($id)
    {
        Log::debug('Deactivating PickupRequestNote in PickupRequestNoteService', ['id' => $id]);
        $pickupRequestNote = $this->pickupRequestNoteRepository->find($id);
        if ($pickupRequestNote) {
          

            return $pickupRequestNote;
        }

        return null; 
    }

    public function deletePickupRequestNote($id)
    {
        Log::debug('Deleting PickupRequestNote in PickupRequestNoteService', ['id' => $id]);
        $pickupRequestNote = $this->pickupRequestNoteRepository->find($id);
        if ($pickupRequestNote) {
            $pickupRequestNote->delete();

            return true;
        }

        return false;
    }

      public function getcustbyname($query)
    {
        Log::info('Fetching Customer by name in ContractService');
        return Customer::where('CustName', 'like', '%' . $query . '%')
                       ->orWhere('sap_cust_code', 'like', '%' . $query . '%')
                       ->select('CustName', 'sap_cust_code')
                       ->get();
    }

   public function getvehiclename($query)
{
    Log::info('Fetching Vehicle by name in VehicleService');
    return Vehicle::where('Vehicle_No', 'like', '%' . $query . '%')
                  ->pluck('Vehicle_No');
}


// public function fetchAllLRNumbers()
// {
//     Log::info('Fetching all LR numbers in PickupRequestNoteService');

//     try {
//         // Fetch all LR numbers using Eloquent ORM
//         $lrNumbers = lrdata::where('status', '1')->pluck('id');

//         // Return the fetched LR numbers
//         return $lrNumbers;
               
//     } catch (\Exception $e) {
//         // Log the exception
//         Log::error('Error fetching LR numbers: ' . $e->getMessage());

       
//         return [];
//     }
// }


public function fetchAllLRNumbers()
{
    Log::info('Fetching all LR numbers and package numbers in PickupRequestNoteService');

    try {
        // Fetch all LR numbers and package numbers using Eloquent ORM
        $lrNumbers = lrdata::join('fb_consignment', 'fb_lr.id', '=', 'fb_consignment.lr_id')
            ->select(
                'fb_lr.id as lr_id',
                'fb_consignment.num_of_pkgs'
            )
            ->where('status', '1')
            ->get(); // Use get() instead of pluck()

        // Return the fetched LR numbers and package numbers
        return $lrNumbers;
               
    } catch (\Exception $e) {
        // Log the exception
        Log::error('Error fetching LR numbers and package numbers: ' . $e->getMessage());

        return [];
    }
}






public function UpdateLr($lr_id)
{
    Log::info('Updating LR number in PickupRequestNoteService');

    try {
        // Update the LR record with the provided $lr_id
        $lr = lrdata::where('id', $lr_id)->first();
        if ($lr) {
            $lr->status = '7'; // Assuming '7' is the status code for the update
            $lr->save();
            Log::info('LR number updated successfully: ' . $lr_id);
            return $lr;
        } else {
            Log::error('LR number not found: ' . $lr_id);
            return null;
        }
    } catch (\Exception $e) {
        // Log the exception
        Log::error('Error updating LR number: ' . $e->getMessage());
        return null;
    }
}


public function searchByDate($fromDate, $toDate)
{
    Log::debug('Searching pickup request notes by date in PickupRequestNoteService');
    
    try {
        // Perform the query to fetch pickup request notes by date range
        $pickupRequestNotes = PickupRequestNote::whereBetween('pickup_datetime', [$fromDate, $toDate])->get();

        return $pickupRequestNotes;
    } catch (\Exception $e) {
        // Log the exception
        Log::error('Error searching pickup request notes by date: ' . $e->getMessage());
        
        // Return an empty array or handle the error as needed
        return [];
    }
}

public function searchByPRN($prn)
{
    Log::debug('Searching pickup request notes by PRN in PickupRequestNoteService');
    
    try {
        // Perform the query to fetch pickup request notes by PRN number
        $pickupRequestNotes = PickupRequestNote::where('id', $prn)->get();

        return $pickupRequestNotes;
    } catch (\Exception $e) {
        // Log the exception
        Log::error('Error searching pickup request notes by PRN: ' . $e->getMessage());
        
        // Return an empty array or handle the error as needed
        return [];
    }
}


// public function searchprnarrival($prn)
// {
//     Log::debug('Searching pickup request notes by PRN in PickupRequestNoteService');
    
//     try {
//         // Perform the query to fetch pickup request notes by PRN number
//         $pickupRequestNotes = PickupRequestNote::where('id', $prn)->get();

//        // print_r($pickupRequestNotes); // Use print_r() for debugging

//         return $pickupRequestNotes;
//     } catch (\Exception $e) {
//         // Log the exception
//         Log::error('Error searching pickup request notes by PRN: ' . $e->getMessage());
        
//         // Return an empty array or handle the error as needed
//         return [];
//     }
// }


public function searchprnarrival($prn)
{
    Log::debug('Searching pickup request notes by PRN in PickupRequestNoteService');
    
    try {
        // First query to fetch pickup request notes by PRN number
        $pickupRequestNotes = PickupRequestNote::where('id', $prn)->get();

        // Second query to perform join operation
     $pickupRequestDetails = PrnLrModel::join('fb_lr AS T2', 'fm_prn_lr.lr_id', '=', 'T2.id')
    ->select('fm_prn_lr.lr_id', 'T2.created_at', 'T2.to_place', 'T2.total_num_of_pkgs', 'fm_prn_lr.recievedqty', 'fm_prn_lr.reason')
    ->where('fm_prn_lr.prn_id', $prn)
    ->get();

        
   

        // Return both results
        return [
            'pickupRequestNotes' => $pickupRequestNotes,
            'pickupRequestDetails' => $pickupRequestDetails
        ];
    } catch (\Exception $e) {
        // Log the exception
        Log::error('Error searching pickup request notes by PRN: ' . $e->getMessage());
        
        // Return an empty array or handle the error as needed
        return [];
    }
}





}