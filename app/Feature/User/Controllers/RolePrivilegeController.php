<?php

namespace App\Feature\User\Controllers;

use App\Feature\User\Requests\RolePrivilegeStoreRequest;
use App\Feature\User\Services\RolePrivilegeService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Feature\User\Models\Role;
use App\Feature\User\Models\Privilege;
use Illuminate\Support\Facades\Log;

class RolePrivilegeController extends Controller
{
    protected $roleprivilegeService;

    public function __construct(RolePrivilegeService $roleprivilegeService)
    {
        $this->roleprivilegeService = $roleprivilegeService;
    }

    public function store(RolePrivilegeStoreRequest $request)
    {
        Log::info('Role Privilege store method called in RolePrivilegeController');

        // Map role name to ID
        $role = Role::where('name', $request->input('role_id'))->first();
        if (!$role) {
            return response()->json(['error' => 'Role not found'], 404);
        }

        // Map privilege name to ID
        $privilege = Privilege::where('name', $request->input('privilege_id'))->first();
        if (!$privilege) {
            return response()->json(['error' => 'Privilege not found'], 404);
        }

        // Prepare data for insertion
        $data = [
            'role_id' => $role->id,
            'privilege_id' => $privilege->id,
            'updated_at' => now(),
            'created_at' => now(),
        ];

        // Insert into role_privileges table
        $roleprivilege = $this->roleprivilegeService->createRolePrivilege($data);

        return response()->json($roleprivilege, 201); // 201 Created
    }


    public function show($role_id)
    {
        Log::info('Role Privilege show method called in RolePrivilegeController');
        $roleprivilege = $this->roleprivilegeService->getRolePrivilegeByRoleId($role_id);

        return response()->json($roleprivilege);
    }

    public function index(Request $request)
    {
        Log::info('Role Privilege index method called in RolePrivilegeController');
        $roleprivilege = $this->roleprivilegeService->getAllRolePrivileges($request);

        return response()->json($roleprivilege);
    }

    public function update(Request $request, $role_id)
    {
        $roleprivilege = $this->roleprivilegeService->updateRolePrivilege($role_id, $request->all());

        return response()->json($roleprivilege);
    }

    // public function deactivate($role_id)
    // {
    //     $role = $this->roleprivilegeService->deactivateRolePrivilege($role_id);
    //     if ($role) {
    //         $response = $role->toArray(); // Convert the Eloquent model to an array
    //         $response['message'] = 'Role Privilege deactivated successfully';

    //         return response()->json($response, 200);
    //     }

    //     return response()->json([
    //         'role_id' => $role_id,
    //         'message' => 'Role Privilege not found',
    //     ], 404);
    // }

    public function destroy($role_id)
    {
        if ($this->roleprivilegeService->deleteRolePrivilege($role_id)) {
            return response()->json([
                'role_id' => $role_id,
                'deleted' => true,
                'message' => 'RolePrivilege deleted successfully',
            ], 200);
        }

        return response()->json([
            'role_id' => $role_id,
            'message' => 'RolePrivilege not found',
        ], 404);
    }

    // Further methods for other operations (read, update, delete) can be added here
}
