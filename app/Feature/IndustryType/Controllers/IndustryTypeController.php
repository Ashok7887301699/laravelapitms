<?php

namespace App\Feature\IndustryType\Controllers;

use App\Feature\IndustryType\Requests\IndustryTypeStoreRequest;
use App\Feature\IndustryType\Services\IndustryTypeService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IndustryTypeController extends Controller
{
    protected $industrytypeService;

    public function __construct(IndustryTypeService $industrytypeService)
    {
        $this->industrytypeService = $industrytypeService;
    }

    public function store(IndustryTypeStoreRequest $request)
    {
        Log::info('IndustryType store method called in IndustryTypeController');
        $validatedData = $request->validated();
        $industrytype = $this->industrytypeService->createIndustryType($validatedData);

        return response()->json($industrytype, 201); // 201 Created
    }

    public function show($id)
    {
        Log::info('IndustryType show method called in IndustryTypeController');
        $industrytype = $this->industrytypeService->getIndustryTypeById($id);

        return response()->json($industrytype);
    }

    public function index(Request $request)
    {
        Log::info('IndustryType index method called in IndustryTypeController');
        $industrytypes = $this->industrytypeService->getAllIndustryTypes($request);

        return response()->json($industrytypes);
    }

    public function update(Request $request, $id)
    {
        $industrytype = $this->industrytypeService->updateIndustryType($id, $request->all());

        return response()->json($industrytype);
    }

    public function deactivate($id)
    {
        $industrytype = $this->industrytypeService->deactivateIndustryType($id);
        if ($industrytype) {
            $response = $industrytype->toArray(); // Convert the Eloquent model to an array
            $response['message'] = 'IndustryType deactivated successfully';

            return response()->json($response, 200);
        }

        return response()->json([
            'id' => $id,
            'message' => 'IndustryType not found',
        ], 404);
    }

    public function destroy($id)
    {
        if ($this->industrytypeService->deleteIndustryType($id)) {
            return response()->json([
                'id' => $id,
                'deleted' => true,
                'message' => 'IndustryType deleted successfully',
            ], 200);
        }

        return response()->json([
            'id' => $id,
            'message' => 'IndustryType not found',
        ], 404);
    }

    // Further methods for other operations (read, update, delete) can be added here
}

