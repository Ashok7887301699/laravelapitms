<?php

namespace App\Feature\ContractPaymentType\Controllers;

use App\Feature\ContractPaymentType\Requests\ContractPaymentTypeStoreRequest;
use App\Feature\ContractPaymentType\Services\ContractPaymentTypeService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContractPaymentTypeController extends Controller
{
    protected $contractpaymenttypeService;

    public function __construct(ContractPaymentTypeService $contractpaymenttypeService)
    {
        $this->contractpaymenttypeService = $contractpaymenttypeService;
    }

    public function store(ContractPaymentTypeStoreRequest $request)
    {
        Log::info('contractpaymenttype store method called in ContractPaymentTypeController');
        $validatedData = $request->validated();
        $contractpaymenttype = $this->contractpaymenttypeService->createContractPaymentType($validatedData);

        return response()->json($contractpaymenttype, 201); // 201 Created
    }

    public function show($id)
    {
        Log::info('contractpaymenttype show method called in ContractPaymentTypeController');
        $contractpaymenttype = $this->contractpaymenttypeService->getContractPaymentTypeById($id);

        return response()->json($contractpaymenttype);
    }

    public function index(Request $request)
    {
        Log::info('contractpaymenttype index method called in ContractPaymentTypeController');
        $contractpaymenttypes = $this->contractpaymenttypeService->getAllContractPaymentType($request);

        return response()->json($contractpaymenttypes);
    }

    public function update(Request $request, $id)
    {
        $contractpaymenttype = $this->contractpaymenttypeService->updateContractPaymentType($id, $request->all());

        return response()->json($contractpaymenttype);
    }

    public function deactivate($id)
    {
        $contractpaymenttype = $this->contractpaymenttypeService->deactivateContractPaymentType($id);
        if ($contractpaymenttype) {
            $response = $contractpaymenttype->toArray(); // Convert the Eloquent model to an array
            $response['message'] = 'contractpaymenttype deactivated successfully';

            return response()->json($response, 200);
        }

        return response()->json([
            'id' => $id,
            'message' => 'contractpaymenttype not found',
        ], 404);
    }

    public function destroy($id)
    {
        if ($this->contractpaymenttypeService->deleteContractPaymentType($id)) {
            return response()->json([
                'id' => $id,
                'deleted' => true,
                'message' => 'contractpaymenttype deleted successfully',
            ], 200);
        }

        return response()->json([
            'id' => $id,
            'message' => 'contractpaymenttype not found',
        ], 404);
    }

    // Further methods for other operations (read, update, delete) can be added here
}
