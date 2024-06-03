<?php
namespace App\Feature\Contract\Controllers;

use App\Http\Controllers\Controller;
use App\Feature\Contract\Requests\Servicerequest;
use App\Feature\Contract\Services\Oda_charge_Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class Oda_charge_controller extends Controller
{
    protected $Oda_charge_Service;

    public function __construct(Oda_charge_Service $Oda_charge_Service)
    {
        $this->Oda_charge_Service = $Oda_charge_Service;
    }

    public function store()
    {
        $validatedData = [
            'to_place' => 'fursungi',
            'oda_charge' => 100
        ];
    
        $contractService = $this->Oda_charge_Service->createodacharge($validatedData);
    
        return response()->json($contractService, Response::HTTP_CREATED);
    }

    public function index()
    {
        Log::info('Service Selection called');
        $excess = $this->Oda_charge_Service->getAllodacharge();

        return response()->json($excess);
    }

    public function getById($id)
    {
        $service = $this->Oda_charge_Service->getodachargebyid($id);
        return response()->json($service);
    }

    public function update(Request $request, $id)
    {
        $service = $this->Oda_charge_Service->updateodachargeId($id, $request->all());

        return response()->json($service);
    }
}
