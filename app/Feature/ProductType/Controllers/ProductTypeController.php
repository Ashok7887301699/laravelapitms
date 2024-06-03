<?php

namespace App\Feature\ProductType\Controllers;

use App\Feature\ProductType\Requests\ProductTypeStoreRequest;
use App\Feature\ProductType\Services\ProductTypeService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductTypeController extends Controller
{
    protected $productTypeService;

    public function __construct(ProductTypeService $productTypeService)
    {
        $this->productTypeService = $productTypeService;
    }

    public function store(ProductTypeStoreRequest $request)
    {
        $validatedData = $request->validated();
        $producttype = $this->productTypeService->createProductType($validatedData);

        return response()->json($producttype, 201); // 201 Created
    }

    public function show($id)
    {
        Log::info('Product type show method called in ProductTypeController');
        $productType = $this->productTypeService->getProductTypeById($id);

        return response()->json($productType);
    }

    public function index(Request $request)
    {
        Log::info('Product type index method called in ProductTypeController');
        $productTypes = $this->productTypeService->getAllProductTypes($request);

        return response()->json($productTypes);
    }

    public function update(Request $request, $id)
    {
        $Producttype = $this->productTypeService->updateProductType($id, $request->all());

        return response()->json($Producttype);
    }

    public function deactivate($id)
    {
        Log::info('Product type deactivate method called in ProductTypeController');
        $productType = $this->productTypeService->deactivateProductType($id);

        if ($productType) {
            $response = $productType->toArray();
            $response['message'] = 'Product type deactivated successfully';
            return response()->json($response, 200);
        }

        return response()->json([
            'id' => $id,
            'message' => 'Product type not found',
        ], 404);
    }

    public function destroy($id)
    {
        Log::info('Product type destroy method called in ProductTypeController');
        if ($this->productTypeService->deleteProductType($id)) {
            return response()->json([
                'id' => $id,
                'deleted' => true,
                'message' => 'Product type deleted successfully',
            ], 200);
        }

        return response()->json([
            'id' => $id,
            'message' => 'Product type not found',
        ], 404);
    }
}