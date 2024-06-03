<?php

namespace App\Feature\User\Services;

use App\Feature\User\Models\RolePrivilege;
use App\Feature\User\Repositories\RolePrivilegeRepository;
use Illuminate\Support\Facades\Log;

class RolePrivilegeService
{
    protected $roleprivilegeRepository;

    public function __construct(RolePrivilegeRepository $roleprivilegeRepository)
    {
        $this->roleprivilegeRepository = $roleprivilegeRepository;
    }

    public function createRolePrivilege(array $data)
    { 
        return $this->roleprivilegeRepository->create($data);
    }

    public function getRolePrivilegeByRoleId($role_id)
{
    // Assuming RolePrivilege model has a column named 'role_id'
    return RolePrivilege::where('role_id', $role_id)->get();
}

    public function getAllRolePrivileges($request)
    {
        $query = RolePrivilege::query();

        // Filter by 'name'
        if ($request->has('role_id')) {
            $query->where('role_id', 'like', '%' . $request->role_id . '%');
        }
        if ($request->has('privilege_id')) {
            $query->where('privilege_id', 'like', '%' . $request->privilege_id . '%');
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



    public function updateRolePrivilege($role_id, array $data)
    {
        $roleprivilege = $this->roleprivilegeRepository->find($role_id);

        if ($roleprivilege) {
            $roleprivilege->update($data);
        }

        return $roleprivilege;
    }

    public function deactivateRolePrivilege($role_id)
    {
        $roleprivilege = $this->roleprivilegeRepository->find($role_id);
        if ($roleprivilege) {
            $roleprivilege->update(['status' => 'DEACTIVATED']);

            return $roleprivilege;
        }

        return null; // Handle the case where the role is not found
    }

    public function deleteRolePrivilege($role_id)
    {
        $roleprivilege = $this->roleprivilegeRepository->find($role_id);

        if ($roleprivilege) {
            // Delete the role
            $roleprivilege->delete();

            return true;
        }

        return false;
    }
}
