<?php

namespace App\Feature\ProductType\Services;

use App\Feature\ProductType\Models\ProductType;
use App\Feature\ProductType\Repositories\ProductTypeRepository;
use Illuminate\Support\Facades\Log;

class ProductTypeService
{
    protected $productTypeRepository;

    public function __construct(ProductTypeRepository $productTypeRepository)
    {
        $this->productTypeRepository = $productTypeRepository;
    }

    public function createProductType(array $data)
    {
        return $this->productTypeRepository->create($data);
    }

    public function getProductTypeById($id)
    {
        return $this->productTypeRepository->find($id);
    }

    public function getAllProductTypes($request)
    {
        $query = ProductType::query();

        // Filter by 'name'
        if ($request->has('product_type')) {
            $query->where('product_type', 'like', '%' . $request->product_type . '%');
        }

        // Filter by 'status'
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by 'created_at' date range
        if ($request->has(['created_from', 'created_to'])) {
            $query->whereBetween('created_at', [$request->created_from, $request->created_to]);
        }

        // Filter by 'updated_at' date range
        if ($request->has(['updated_from', 'updated_to'])) {
            $query->whereBetween('updated_at', [$request->updated_from, $request->updated_to]);
        }

        // Sorting
        $query->orderBy($request->get('sort_by', 'updated_at'), $request->get('sort_order', 'desc'));

        // Pagination
        $perPage = $request->get('per_page', 10); // Default to 10 if not provided

        return $query->paginate($perPage);
    }



    public function updateProductType($id, array $data)
    {
        $productType = $this->productTypeRepository->find($id);

        if ($productType) {
            $productType->update($data);
        }

        return $productType;
    }

    public function deactivateProductType($id)
    {
        $tenant = $this->productTypeRepository->find($id);
        if ($tenant) {
            $tenant->update(['status' => 'DEACTIVATED']);

            return $tenant;
        }

        return null; // Handle the case where the tenant is not found
    }

    public function deleteProductType($id)
    {
        $productType = $this->productTypeRepository->find($id);

        if ($productType) {
            // Delete the product type
            $productType->delete();

            return true;
        }

        return false;
    }
}
