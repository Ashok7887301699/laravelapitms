<?php

namespace App\Feature\User\Services;

use App\Feature\User\Models\Privilege;
use App\Feature\User\Repositories\PrivilegeRepository;
use Illuminate\Support\Facades\Log;

class PrivilegeService
{
    protected $privilegeRepository;

    public function __construct(PrivilegeRepository $privilegeRepository)
    {
        $this->privilegeRepository = $privilegeRepository;
    }

    public function createPrivilege(array $data)
    { 
        return $this->privilegeRepository->create($data);
    }

    public function getPrivilegeById($id)
    {
        return $this->privilegeRepository->find($id);
    }

    public function getAllPrivileges($request)
    {
        $query = Privilege::query();

        // Filter by 'name'
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->has('description')) {
            $query->where('description', 'like', '%' . $request->description . '%');
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



    public function updatePrivilege($id, array $data)
    {
        $privilege = $this->privilegeRepository->find($id);

        if ($privilege) {
            $privilege->update($data);
        }

        return $privilege;
    }

    public function deactivatePrivilege($id)
    {
        $privilege = $this->privilegeRepository->find($id);
        if ($privilege) {
            $privilege->update(['status' => 'DEACTIVATED']);

            return $privilege;
        }

        return null; // Handle the case where the Privilege is not found
    }

    public function deletePrivilege($id)
    {
        $privilege = $this->privilegeRepository->find($id);

        if ($privilege) {
            // Delete the Privilege type
            $privilege->delete();

            return true;
        }

        return false;
    }
}
