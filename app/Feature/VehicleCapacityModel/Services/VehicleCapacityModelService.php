<?php

namespace App\Feature\VehicleCapacityModel\Services;

use App\Feature\VehicleCapacityModel\Models\VehicleCapacityModel;
use App\Feature\VehicleCapacityModel\Repositories\VehicleCapacityModelRepository;
use Illuminate\Support\Facades\Log;

class VehicleCapacityModelService
{
    protected $vehiclecapacitymodelRepository;

    public function __construct(VehicleCapacityModelRepository $vehiclecapacitymodelRepository)
    {
        $this->vehiclecapacitymodelRepository = $vehiclecapacitymodelRepository;
    }

    public function createVehicleCapacityModel(array $data)
    {
        $data['vehcpctmodel'] = strtoupper($data['vehcpctmodel']);
        $data['vehiclecpct'] = strtoupper($data['vehiclecpct']); 
        $data['modeldesc'] = strtoupper($data['modeldesc']); 
        return $this->vehiclecapacitymodelRepository->create($data);
    }

    public function getVehicleCapacityModelById($id)
    {
        return $this->vehiclecapacitymodelRepository->find($id);
    }

    public function getAllVehicleCapacityModels($request)
    {
        $query = VehicleCapacityModel::query();

        // Filter by 'name'
        if ($request->has('vehcpctmodel')) {
            $query->where('vehcpctmodel', 'like', '%' . $request->vehcpctmodel . '%');
        }

        if ($request->has('vehiclecpct')) {
            $query->where('vehiclecpct', 'like', '%' . $request->vehiclecpct . '%');
        } 

        if ($request->has('modeldesc')) {
            $query->where('modeldesc', 'like', '%' . $request->modeldesc . '%');
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



    public function updateVehicleCapacityModel($id, array $data)
    {
        $vehiclecapacitymodel = $this->vehiclecapacitymodelRepository->find($id);

        if ($vehiclecapacitymodel) {
            $vehiclecapacitymodel->update($data);
        }

        return $vehiclecapacitymodel;
    }

    public function deactivateVehicleCapacityModel($id)
    {
        $vehiclecapacitymodel = $this->vehiclecapacitymodelRepository->find($id);
        if ($vehiclecapacitymodel) {
            $vehiclecapacitymodel->update(['status' => 'DEACTIVATED']);

            return $vehiclecapacitymodel;
        }

        return null; // Handle the case where the vehiclecapacitymodel is not found
    }

    public function deleteVehicleCapacityModel($id)
    {
        $vehiclecapacitymodel = $this->vehiclecapacitymodelRepository->find($id);

        if ($vehiclecapacitymodel) {
            // Delete the vehiclecapacitymodel type
            $vehiclecapacitymodel->delete();

            return true;
        }

        return false;
    }
}
