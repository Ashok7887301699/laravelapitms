<?php

namespace App\Feature\User\Services;

use App\Feature\User\Models\Role;
use App\Feature\User\Repositories\RoleRepository;
use Illuminate\Support\Facades\Log;

class RoleService
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function createRole(array $data)
    { 
        return $this->roleRepository->create($data);
    }

    public function getRoleById($id)
    {
        return $this->roleRepository->find($id);
    }

    public function getAllRoles($request)
    {
        $query = Role::query();

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



    public function updateRole($id, array $data)
    {
        $role = $this->roleRepository->find($id);

        if ($role) {
            $role->update($data);
        }

        return $role;
    }

    public function deactivateRole($id)
    {
        $role = $this->roleRepository->find($id);
        if ($role) {
            $role->update(['status' => 'DEACTIVATED']);

            return $role;
        }

        return null; // Handle the case where the role is not found
    }

    public function deleteRole($id)
    {
        $role = $this->roleRepository->find($id);

        if ($role) {
            // Delete the role
            $role->delete();

            return true;
        }

        return false;
    }

    public function getAllRoleNames()
    {
        return Role::pluck('name')->toArray();
    }
}
