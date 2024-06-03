<?php

namespace App\Feature\PackageType\Services;

use App\Feature\PackageType\Models\PackageType;
use App\Feature\PackageType\Repositories\PackageTypeRepository;

class PackageTypeService
{
    protected $packagetypeRepository;

    public function __construct(PackageTypeRepository $packagetypeRepository)
    {
        $this->packagetypeRepository = $packagetypeRepository;
    }

    public function createPackageType(array $data)
    {
        // Additional business logic before saving can go here
        return $this->packagetypeRepository->create($data);
    }

    public function getPackageTypeById($id)
    {
        return $this->packagetypeRepository->find($id);
    }

    public function getAllPackageType($request)
    {

        $query = PackageType::query();

        // Filter by 'package_type'
        if ($request->has('package_type')) {
            $query->where('package_type', 'like', '%'.$request->package_type.'%');
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

    public function updatePackageType($id, array $data)
    {
        $packagetype = $this->packagetypeRepository->find($id);
        if ($packagetype) {
            $packagetype->update($data);
        }

        return $packagetype;
    }

    public function deactivatePackageType($id)
    {
        $packagetype = $this->packagetypeRepository->find($id);
        if ($packagetype) {
            $packagetype->update(['status' => 'DEACTIVATED']);

            return $packagetype;
        }

        return null; // Handle the case where the packagetype is not found
    }

    public function deletePackageType($id)
    {
        $packagetype = $this->packagetypeRepository->find($id);
        if ($packagetype) {
            $packagetype->delete();

            return true;
        }

        return false;
    }
}
