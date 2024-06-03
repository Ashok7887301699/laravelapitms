<?php

namespace App\Feature\Vendor\Services;

use App\Feature\Vendor\Models\Vendor;
use App\Feature\Vendor\Repositories\VendorRepository;

class VendorService
{
    protected $vendorRepository;

    public function __construct(VendorRepository $vendorRepository)
    {
        $this->vendorRepository = $vendorRepository;
    }

    public function createVendor(array $data)
    {
        // Additional business logic before saving can go here
        return $this->vendorRepository->create($data);
    }

    public function getVendorById($id)
    {
        return $this->vendorRepository->find($id);
    }

    public function getAllVendor($request)
    {

        $query = Vendor::query();

        // Filter by 'VendorCode'
        if ($request->has('VendorCode')) {
            $query->where('VendorCode', 'like', '%'.$request->VendorCode.'%');
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

    public function updateVendor($id, array $data)
    {
        $vendor = $this->vendorRepository->find($id);
        if ($vendor) {
            $vendor->update($data);
        }

        return $vendor;
    }

    public function deactivateVendor($id)
    {
        $vendor = $this->vendorRepository->find($id);
        if ($vendor) {
            $vendor->update(['status' => 'DEACTIVATED']);

            return $vendor;
        }

        return null; // Handle the case where the vendor is not found
    }

    public function deleteVendor($id)
    {
        $vendor = $this->vendorRepository->find($id);
        if ($vendor) {
            $vendor->delete();

            return true;
        }

        return false;
    }

    
}
