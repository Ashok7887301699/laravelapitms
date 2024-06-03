<?php

namespace App\Feature\Branch\Services;

use App\Feature\Branch\Models\BranchType;
use App\Feature\Branch\Repositories\BranchTypeRepository;
use Illuminate\Support\Facades\Log;

class BranchTypeService
{
    protected $branchTypeRepository;

    public function __construct(BranchTypeRepository $branchTypeRepository)
    {
        $this->branchTypeRepository = $branchTypeRepository;
    }

    public function createBranchType(array $data)
    {
        Log::info('In createBranchType Method in Service');

        return $this->branchTypeRepository->create($data);
    }

    public function getBranchTypeById($id)
    {
        return $this->branchTypeRepository->find($id);
    }

    public function getAllBranchTypes($request)
    {
        $query = BranchType::query();

        // Filtering logic can be added here based on the request parameters

        // Sorting logic
        $sortBy = $request->get('sort_by', 'updated_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 10);

        return $query->paginate($perPage);
    }

    public function updateBranchType($id, array $data)
    {
        $branchType = $this->branchTypeRepository->find($id);
        if ($branchType) {
            $branchType->update($data);
        }

        return $branchType;
    }

    public function deactivateBranchType($id)
    {


        Log::debug('Deactivating india in IndiaService', ['id' => $id]);
        $branchType = $this->branchTypeRepository->find($id);
        if ($branchType) {
            $branchType->update(['status' => 'DEACTIVATED']);

            return $branchType;
        }

        return null; // Handle the case where the India is not found
    }

    public function deleteBranchType($id)
    {
        //return $this->branchTypeRepository->delete($id);

        Log::debug('Deleting india in BranchTypeService', ['id' => $id]);
        $branchtype = $this->branchTypeRepository->find($id);
        if ($branchtype) {
            $branchtype->delete();

            return true;
        }

        return false;
    }

    public function getAllBranchTypesOnly()
    {
        Log::info('Fetching active branch types in BranchTypeService');

        return BranchType::where('status', 'ACTIVE')->pluck('branch_type')->toArray();
    }

}
