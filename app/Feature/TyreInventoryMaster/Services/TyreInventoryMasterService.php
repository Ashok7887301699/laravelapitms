<?php

namespace App\Feature\TyreInventoryMaster\Services;

use App\Feature\TyreInventoryMaster\Models\TyreInventoryMaster;
use App\Feature\TyreInventoryMaster\Repositories\TyreInventoryMasterRepository;
use Illuminate\Http\Request;

class TyreInventoryMasterService
{
    protected $tyreInventoryMasterRepository;

    public function __construct(TyreInventoryMasterRepository $tyreInventoryMasterRepository)
    {
        $this->tyreInventoryMasterRepository = $tyreInventoryMasterRepository;
    }

    public function createTyreInventoryMaster(array $data)
    {
        // Additional business logic before saving can go here
        return $this->tyreInventoryMasterRepository->create($data);
    }

    public function getTyreInventoryMasterById($id)
    {
        return $this->tyreInventoryMasterRepository->find($id);
    }

    public function getAllTyreInventoryMaster(Request $request)
    {
        $query = TyreInventoryMaster::query();

        // Apply filters
        if ($request->has('tyre_code')) {
            $query->where('tyre_code', 'like', '%' . $request->tyre_code . '%');
        }

        if ($request->has('tyre_number')) {
            $query->where('tyre_number', 'like', '%' . $request->tyre_number . '%');
        }

        if ($request->has('tyre_status')) {
            $query->where('tyre_status', $request->tyre_status);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has(['purchase_date_from', 'purchase_date_to'])) {
            $query->whereBetween('purchase_date', [$request->purchase_date_from, $request->purchase_date_to]);
        }

        if ($request->has(['created_from', 'created_to'])) {
            $query->whereBetween('created_at', [$request->created_from, $request->created_to]);
        }

        if ($request->has(['updated_from', 'updated_to'])) {
            $query->whereBetween('updated_at', [$request->updated_from, $request->updated_to]);
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'updated_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Get all records
        $allTyreInventoryMaster = $query->get();

        return $allTyreInventoryMaster;
    }

    public function updateTyreInventoryMaster($id, array $data)
    {
        $tyreInventoryMaster = $this->tyreInventoryMasterRepository->find($id);
        if ($tyreInventoryMaster) {
            $tyreInventoryMaster->update($data);
            return $tyreInventoryMaster;
        }
        return null;
    }

    public function deactivateTyreInventoryMaster($id)
    {
        $tyreInventoryMaster = $this->tyreInventoryMasterRepository->find($id);
        if ($tyreInventoryMaster) {
            $tyreInventoryMaster->update(['status' => 'DEACTIVATED']);
            return $tyreInventoryMaster;
        }
        return null; // Handle the case where the TyreInventoryMaster is not found
    }

    public function deleteTyreInventoryMaster($id)
    {
        $tyreInventoryMaster = $this->tyreInventoryMasterRepository->find($id);
        if ($tyreInventoryMaster) {
            $tyreInventoryMaster->delete();
            return true;
        }
        return false;
    }
}
