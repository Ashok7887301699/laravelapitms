<?php

namespace App\Feature\Contract\Controllers;

use App\Feature\Contract\Requests\Servicerequest;
use App\Feature\Contract\Services\Doordeliveryservice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Feature\Contract\Models\contract_door_deliverie;


class DoordeliverController extends Controller
{
    protected $Doordeliveryservice;

    public function __construct(Doordeliveryservice $Doordeliveryservice)
    {
        $this->Doordeliveryservice = $Doordeliveryservice;
    }
    // public function insert()
    // {
    //     $data = [
    //         'contract_id' => 12,
    //         'from_place' => 'pune', 
    //         'to_place' => 'karad',
    //         'rate' => 13,
    //     ];
    
    //     // Call the createExcess method and pass the validated data
    //     $contractService = $this->Doordeliveryservice->createdoordeliver($data);
    
    //     return response()->json($contractService, 201); // Return the created service
    // }

    public function insert(Request $request)
    {
        Log::info('Doordeliveryservice store method called in Doordeliveryservice');
        try {
            $requestData = $request->input('data');
            
            if (!isset($requestData) || !is_array($requestData)) {
                throw new \InvalidArgumentException('Data not provided or invalid format.');
            }
            
            $createdContractDeliveries = [];
    
            foreach ($requestData as $data) {
                // Create a new Doordelivery instance
                $newDelivery = new contract_door_deliverie();
                
                // Assign values from the request data
                $newDelivery->from_place = $data['from_place'];
                $newDelivery->to_place = $data['to_place'];
                $newDelivery->rate = $data['rate'];
                
                // Assuming you have logic to determine contract_id, replace '1' with your actual logic
                $newDelivery->contract_id = $data['contract_id']; // Example value, replace with your actual logic
                
                // Save the new Doordelivery instance
                $newDelivery->save();
                
                // Add the saved Doordelivery instance to the response array
                $createdContractDeliveries[] = $newDelivery;
            }
    
            return response()->json($createdContractDeliveries, 201); // Return the created deliveries
        } catch (\Exception $e) {
            Log::error('Error creating Doordelivery: ' . $e->getMessage());
            return response()->json(['message' => 'Error creating Doordelivery'], 500);
        }
    }
    public function index()
    {
        Log::info('Service Selection called');
        $Doordeliveryservice = $this->Doordeliveryservice->getAllDoordeliverys();

        return response()->json($Doordeliveryservice);
    }
    public function getbyid($contract_id)
    {
        $service = $this->Doordeliveryservice->getratesById($contract_id);
        return response()->json($service);
        
    }

    public function update(Request $request, $contract_id)
    {
        $validatedData = $request->input();
        
        // Check if data is provided
        if (empty($validatedData)) {
            return response()->json([
                'message' => 'Failed to update entries',
                'errors' => 'No data provided',
            ], 400); // 400 Bad Request
        }
        
        // Call the updateratesById method and pass each entry with the contract ID
        $updatedEntries = $this->Doordeliveryservice->updateratesById($validatedData, $contract_id);
        
        return response()->json($updatedEntries, 200); // 200 OK
    }
}