<?php
namespace App\Feature\Vehicle\Services;

use App\Feature\Vehicle\Repositories\VehicleRepository;
use App\Feature\Vehicle\Models\Vehicle;
use Illuminate\Http\Request;
use App\Feature\Vehicle\Models\vehcpctmodel;


class VehicleService
{
    protected $VehicleRepository;

    public function __construct(VehicleRepository $VehicleRepository)
    {
        $this->VehicleRepository = $VehicleRepository;
    }
    public function createVehicle(array $data)
    {
        // $nextSrNo = Vehicle::max('SrNo') + 1;

        // // Add SrNo to data
        // $data['SrNo'] = $nextSrNo;

        $maxSrNo = Vehicle::max('SrNo');

        // If no records exist, set SrNo to 1
        $nextSrNo = $maxSrNo ? $maxSrNo + 1 : 1;

        // Add SrNo to data
        $data['SrNo'] = $nextSrNo;

        // Additional business logic before saving can go here
        return $this->VehicleRepository->create($data);
    }
    public function getVehicleById($SrNo)
    {
        return $this->VehicleRepository->find($SrNo);
    }


    public function getAllVehicles(Request $request)
    {
        $query = Vehicle::query();

        if ($request->has('VehicleType')) {
            $query->where('VehicleType', 'like', '%' . $request->input('VehicleType') . '%');
        }

        if ($request->has('Vehicle_No')) {
            $query->where('Vehicle_No', 'like', '%' . $request->input('Vehicle_No') . '%');
        }

        if ($request->has('VendorName')) {
            $query->where('VendorName', 'like', '%' . $request->input('VendorName') . '%');
        }

        // Filter by 'Status'
        if ($request->has('ActiveFlag')) {
            $query->where('ActiveFlag', $request->input('ActiveFlag'));
        }

        // Filter by 'created_at' date range
        if ($request->has(['created_from', 'created_to'])) {
            $query->whereBetween('created_at', [$request->input('created_from'), $request->input('created_to')]);
        }

        // Filter by 'updated_at' date range
        if ($request->has(['updated_from', 'updated_to'])) {
            $query->whereBetween('updated_at', [$request->input('updated_from'), $request->input('updated_to')]);
        }


        // Sorting
        $sortBy = $request->input('sort_by', 'updated_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->input('per_page', 10);
        return $query->paginate($perPage);

       // $vehicles = $query->get();

    //return $vehicles;
    }

    public function fetchvehcpctmodel()
    {

        $vehcpctmodel = vehcpctmodel::groupBy('vehcpctmodel')->pluck('vehcpctmodel')->toArray();

        return $vehcpctmodel;
    }
    public function fetchVehiclecpct()
    {
        return vehcpctmodel::groupBy('vehiclecpct')->pluck('vehiclecpct')->toArray();
    }


    public function updateVehicle($SrNo, array $data)
    {
        $Vehicle = $this->VehicleRepository->find($SrNo);
        if ($Vehicle) {
            $Vehicle->update($data);
        }

        return $Vehicle;
    }


    public function deactivateVehicle($SrNo)
    {
        $Vehicle = $this->VehicleRepository->find($SrNo);
        if ($Vehicle) {
            $Vehicle->update(['ActiveFlag' => '0']);

            return $Vehicle;
        }

        return null; // Handle the case where the tenant is not found
    }

    public function deleteVehicle($SrNo)
    {
        $Vehicle = $this->VehicleRepository->find($SrNo);
        if ($Vehicle) {
            $Vehicle->delete();

            return true;
        }

        return false;
    }

}
