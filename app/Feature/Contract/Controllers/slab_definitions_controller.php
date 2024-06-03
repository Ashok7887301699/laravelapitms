<?php

namespace App\Feature\Contract\Controllers;
use App\Feature\Contract\Models\ContractSlabDefinition;
use App\Feature\Contract\Requests\Servicerequest;
use App\Feature\Contract\Services\slab_definitions_service;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class slab_definitions_controller extends Controller
{
    protected $slab_definitionsService;

    public function __construct(slab_definitions_service $slab_definitionsService)
    {
        $this->slab_definitionsService = $slab_definitionsService;
    }

  public function insert(Request $request)
    {
        $slabDefinitionsData = $request->all();
    
        try {
            $slabDefinitions = [];
            foreach ($slabDefinitionsData as $key => $value) {
                if (strpos($key, 'slab_number') !== false) {
                    $index = substr($key, strlen('slab_number')); // Extract the index from the key
                    $slabDefinitions[] = [
                        'contract_id' => $slabDefinitionsData['contract_id'], // Assuming contract_id is always 1
                        'slab_number' => $value,
                        'slab_lower_limit' => $slabDefinitionsData['slab_lower_limit' . $index] ?? 0, // Replace null with 0
                        'slab_upper_limit' => $slabDefinitionsData['slab_upper_limit' . $index] ?? 0,
                        'slab_contract_type' => $slabDefinitionsData['slab_contract_type' . $index] ?? 'NONE',
                        // Replace null with 0
                        'slab_rate_type' => $slabDefinitionsData['slab_rate_type' . $index] ?? 'NONE' // Replace null with default value 'FLAT'
                    ];
                }
            }
    
            ContractSlabDefinition::insert($slabDefinitions);
    
            return response()->json(['message' => 'Slab definitions inserted successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function index(){
        Log::info('Service Selection called');
        $slab= $this->slab_definitionsService->getAllslab();

        return response()->json($slab);
    }
    public function show($id)
    {
        Log::info('Service Selection called');
        $slab= $this->slab_definitionsService->getidbyslab($id);

        return response()->json($slab);
    }
    public function update(Request $request, $id)
    {
        $service = $this->slab_definitionsService->updateslabById($id, $request->all());

        return response()->json($service);
    }




}
