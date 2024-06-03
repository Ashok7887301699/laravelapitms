<?php

namespace App\Feature\VendorFuel\Services;

use App\Feature\VendorFuel\Models\VendorFuel;
use App\Feature\VendorFuel\Repositories\VendorFuelRepository;

class VendorFuelService
{
    protected $vendorfuelRepository;

    public function __construct(VendorFuelRepository $vendorfuelRepository)
    {
        $this->vendorfuelRepository = $vendorfuelRepository;
    }

    public function createVendorFuel(array $data)
    {
        // Additional business logic before saving can go here
        return $this->vendorfuelRepository->create($data);
    }

    public function getVendorFuelById($id)
    {
        return $this->vendorfuelRepository->find($id);
    }

    public function getAllVendorFuel($request)
    {

        $query = VendorFuel::query();

        // Filter by 'PetrolPumpName'
        if ($request->has('PetrolPumpName')) {
            $query->where('PetrolPumpName', 'like', '%'.$request->PetrolPumpName.'%');
        }

        // Filter by 'Vendorname'
        if ($request->has('Vendorname')) {
            $query->where('Vendorname', 'like', '%'.$request->Vendorname.'%');
        }

        // Filter by 'DVendorCode'
        if ($request->has('DVendorCode')) {
            $query->where('DVendorCode', 'like', '%'.$request->DVendorCode.'%');
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

    public function updateVendorFuel($id, array $data)
    {
        $vendorfuel = $this->vendorfuelRepository->find($id);
        if ($vendorfuel) {
            $vendorfuel->update($data);
        }

        return $vendorfuel;
    }

    public function deactivateVendorFuel($id)
    {
        $vendorfuel = $this->vendorfuelRepository->find($id);
        if ($vendorfuel) {
            $vendorfuel->update(['status' => 'DEACTIVATED']);

            return $vendorfuel;
        }

        return null; // Handle the case where the vendorfuel is not found
    }

    public function deleteVendorFuel($id)
    {
        $vendorfuel = $this->vendorfuelRepository->find($id);
        if ($vendorfuel) {
            $vendorfuel->delete();

            return true;
        }

        return false;
    }
}
