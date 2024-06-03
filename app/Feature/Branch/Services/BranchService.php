<?php

namespace App\Feature\Branch\Services;

use App\Feature\Branch\Models\Branch;
use App\Feature\Branch\Repositories\BranchRepository;
use Illuminate\Support\Facades\Log;

class BranchService
{
    protected $branchRepository;

    public function __construct(BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
    }

    public function createBranch(array $data)
    {
        Log::info('In createBranch Methos in Service ');

        return $this->branchRepository->create($data);
    }

    public function getBranchByCode($branchCode)
    {
        return $this->branchRepository->findByBranchCode($branchCode);
    }

    public function getAllBranches($request)
    {
        $query = Branch::query();

        // Filter by 'BranchCode'
        if ($request->has('BranchCode')) {
            $query->where('BranchCode', 'like', '%' . $request->BranchCode . '%');
        }

        // Filter by 'BranchName'
        if ($request->has('BranchName')) {
            $query->where('BranchName', 'like', '%' . $request->BranchName . '%');
        }

        // Filter by 'BranchType'
        if ($request->has('BranchType')) {
            $query->where('BranchType', $request->BranchType);
        }

        // Filter by 'Latitude' and 'Longitude'
        if ($request->has('Latitude')) {
            $query->whereBetween('Latitude', [(float) $request->Latitude - 0.0001, (float) $request->Latitude + 0.0001]);
        }
        if ($request->has('Longitude')) {
            $query->whereBetween('Longitude', [(float) $request->Longitude - 0.0001, (float) $request->Longitude + 0.0001]);
        }

        // Filter by 'Country', 'State', 'District', 'Taluka', 'City'
        $addressColumns = ['Country', 'State', 'District', 'Taluka', 'City'];
        foreach ($addressColumns as $column) {
            if ($request->has($column)) {
                $query->where($column, 'like', '%' . $request->$column . '%');
            }
        }

        // Filter by 'GSTStateCode'
        if ($request->has('GSTStateCode')) {
            $query->where('GSTStateCode', $request->GSTStateCode);
        }

        // Filter by 'Status'
        if ($request->has('Status')) {
            $query->where('Status', $request->Status);
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
        $sortBy = $request->get('sort_by', 'updated_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 10);

        $branches = $query->paginate($perPage);

        // Convert BranchCode to string
        $branches->getCollection()->transform(function ($branch) {
            $branch->BranchCode = (string) $branch->BranchCode;
            return $branch;
        });

        return $branches;
    }


    public function updateBranch($branchCode, array $data)
    {
        $branch = $this->branchRepository->findByBranchCode($branchCode);
        if ($branch) {
            Branch::where('BranchCode', $branchCode)->update($data);
            // $branch->update($data);
            $branch = $this->branchRepository->findByBranchCode($branchCode);
        }

        return $branch;
    }

    public function deactivateBranch($branchCode)
    {
        $branch = $this->branchRepository->findByBranchCode($branchCode);
        if ($branch) {
            // Checking if the branch is already deactivated or not.
            if ($branch->Status === 'DEACTIVATED') {
                return 'It is already deactivated.';
            }
            $branch->update(['Status' => 'DEACTIVATED']);

            return $branch;
        }

        return null;
    }

    public function deleteBranch($branchCode)
    {
        $branch = $this->branchRepository->findByBranchCode($branchCode);
        if ($branch) {
            $branch->delete();

            return true;
        }

        return false;
    }

    public function getAllBranchNamesOnly($request)
    {
        Log::info('Fetching all Branch names');
        return Branch::pluck('BranchName')->toArray();
    }

    public function getAllBranchCodesOnly($request)
    {
        Log::info('Fetching all Branch codes');
        return Branch::pluck('BranchCode')->toArray();
    }

}
