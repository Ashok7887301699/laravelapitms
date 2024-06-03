<?php

namespace App\Feature\DriverMaster\Services;

use App\Feature\DriverMaster\Models\Driver;
use App\Feature\DriverMaster\Repositories\DriverRepository;
use Illuminate\Support\Facades\Log;

class DriverService
{
    protected $driverRepository;

    public function __construct(DriverRepository $driverRepository)
    {
        $this->driverRepository = $driverRepository;
    }

    public function createDriver(array $data)
    {
        return $this->driverRepository->create($data);
    }

    public function getDriverById($id): ?Driver
    {
        return $this->driverRepository->find($id);
    }

    public function getAllDrivers($request)
    {
        $query = Driver::query();

        // Filter by 'Status'
        $validStatus = ['ACTIVE', 'DEACTIVATED'];
        $query->whereIn('Status', $validStatus);

        // Filter by 'DriverCode'
        if ($request->has('DriverCode')) {
            $query->where('DriverCode', 'like', '%' . $request->DriverCode . '%');
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

        $drivers = $query->paginate($perPage);

        return $drivers;
    }


    public function updateDriver($id, array $data)
    {
        Log::debug('Updating driver in DriverService', ['id' => $id, 'data' => $data]);
        $driver = $this->driverRepository->find($id);
        if ($driver) {
            $driver->update($data);
            return $driver;
        }
        Log::error('Driver not found for update', ['id' => $id]);
        return null;
    }

    public function deactivateDriver($id)
    {
        Log::debug('Deactivating driver in DriverService', ['id' => $id]);
        $driver = $this->driverRepository->find($id);
        if ($driver) {
            if ($driver->Status === 'DEACTIVATED') {
                return 'It is already deactivated.';
            }
            $driver->update(['Status' => 'DEACTIVATED']);
            return $driver;
        }
        return null;
    }

    public function deleteDriver($id)
    {
        Log::debug('Deleting driver in DriverService', ['id' => $id]);
        $driver = $this->driverRepository->find($id);
        if ($driver) {
            if ($driver->Status === "DELETED") {
                return 'This account has been deleted before. Please reactivate it to use again.';
            } else {
                $driver->update(['Status' => 'DELETED']);
                return $driver;
            }
        }
        return null;
    }
}