<?php

namespace App\Feature\User\Controllers;

use App\Feature\User\Requests\RoleStoreRequest;
use App\Feature\User\Services\RoleService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Feature\User\Models\Privilege;
use App\Feature\User\Models\RolePrivilege;
use Illuminate\Support\Facades\DB;
use App\Feature\User\Models\Role;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string',
        'description' => 'required|string',
        'status' => 'required|string|in:ACTIVE,DEACTIVATED,BLOCKED',
        'privilege_names.*' => 'required|string', // Validate privilege names
    ]);

    // Start a database transaction
    DB::beginTransaction();

    try {
        // Create the role
        $role = Role::create($validatedData);

        // Retrieve privilege IDs based on privilege names
        $privilegeNames = $validatedData['privilege_names'];
        $privilegeIds = Privilege::whereIn('name', $privilegeNames)->pluck('id')->toArray();

        // Create role-privilege entries
        foreach ($privilegeIds as $privilegeId) {
            RolePrivilege::create([
                'role_id' => $role->id,
                'privilege_id' => $privilegeId,
                'status' => 'ACTIVE', // Set status as required
            ]);
        }

        // Retrieve the applied privileges for the role
        $appliedPrivileges = Privilege::whereIn('id', $privilegeIds)->select('name', 'description')->get();

        // Add the applied privileges to the role object
        $role->appliedPrivileges = $appliedPrivileges;

        // Commit the transaction if everything is successful
        DB::commit();

        return response()->json($role, 201); // Return the newly created role with applied privileges
    } catch (\Exception $e) {
        // Rollback the transaction if an error occurs
        DB::rollBack();
        return response()->json(['error' => 'Failed to create role: ' . $e->getMessage()], 500);
    }
}

    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'name' => 'required|string',
    //         'description' => 'required|string',
    //         'status' => 'required|string|in:ACTIVE,DEACTIVATED,BLOCKED',
    //         'privilege_names.*' => 'required|string', // Validate privilege names
    //     ]);
    
    //     // Start a database transaction
    //     DB::beginTransaction();
    
    //     try {
    //         // Create the role
    //         $role = Role::create($validatedData);
    
    //         // Retrieve privilege IDs based on privilege names
    //         $privilegeNames = $validatedData['privilege_names'];
    //         $privilegeIds = Privilege::whereIn('name', $privilegeNames)->pluck('id')->toArray();
    
    //         // Create role-privilege entries
    //         foreach ($privilegeIds as $privilegeId) {
    //             RolePrivilege::create([
    //                 'role_id' => $role->id,
    //                 'privilege_id' => $privilegeId,
    //                 'status' => 'ACTIVE', // Set status as required
    //             ]);
    //         }
    
    //         // Commit the transaction if everything is successful
    //         DB::commit();
    
    //         return response()->json($role, 201); // Return the newly created role
    //     } catch (\Exception $e) {
    //         // Rollback the transaction if an error occurs
    //         DB::rollBack();
    //         return response()->json(['error' => 'Failed to create role: ' . $e->getMessage()], 500);
    //     }
    // }

    // public function store(RoleStoreRequest $request)
    // {
    //     // Extract role data from the request
    //     $roleData = $request->only(['name', 'description', 'status']);
    
    //     // Extract privilege names from the request
    //     $privilegeNames = $request->input('privilege_names');
    
    //     // Start a database transaction
    //     DB::beginTransaction();
    
    //     try {
    //         // Create the role
    //         $role = Role::create($roleData);
    
    //         foreach ($privilegeNames as $privilegeName) {
    //             // Find the privilege by name
    //             $privilege = Privilege::where('name', $privilegeName)->first();
    
    //             // Check if the privilege exists
    //             if ($privilege) {
    //                 // Create entry in RolePrivilege table
    //                 RolePrivilege::create([
    //                     'role_id' => $role->id,
    //                     'privilege_id' => $privilege->id,
    //                     'status' => 'ACTIVE', // Set the status as required
    //                 ]);
    //             } else {
    //                 // Rollback the transaction if any privilege doesn't exist
    //                 DB::rollBack();
    //                 return response()->json(['error' => 'One or more privileges not found'], 404);
    //             }
    //         }
    
    //         // Commit the transaction if everything is successful
    //         DB::commit();
    
    //         return response()->json($role, 201); // Return the newly created role
    //     } catch (\Exception $e) {
    //         // Rollback the transaction if an error occurs
    //         DB::rollBack();
    //         return response()->json(['error' => 'Failed to create role'], 500);
    //     }
    // }
    

    public function show($id)
{
    Log::info('Role show method called in RoleController');
    $role = $this->roleService->getRoleById($id);
    $appliedPrivileges = $role->privileges()->get(); // Retrieve applied privileges for the role
    $role->appliedPrivileges = $appliedPrivileges; // Add applied privileges to the role object

    return response()->json($role);
}
    public function index(Request $request)
    {
        Log::info('Role index method called in RoleController');
        $role = $this->roleService->getAllRoles($request);

        return response()->json($role);
    }

    public function update(Request $request, $id)
    {
        $role = $this->roleService->updateRole($id, $request->all());

        return response()->json($role);
    }

    public function deactivate($id)
    {
        $role = $this->roleService->deactivateRole($id);
        if ($role) {
            $response = $role->toArray(); // Convert the Eloquent model to an array
            $response['message'] = 'Role deactivated successfully';

            return response()->json($response, 200);
        }

        return response()->json([
            'id' => $id,
            'message' => 'Role not found',
        ], 404);
    }

    public function destroy($id)
    {
        if ($this->roleService->deleteRole($id)) {
            return response()->json([
                'id' => $id,
                'deleted' => true,
                'message' => 'Role deleted successfully',
            ], 200);
        }

        return response()->json([
            'id' => $id,
            'message' => 'Role not found',
        ], 404);
    }

    public function getAllRoleNames()
    {
        $roleNames = $this->roleService->getAllRoleNames();

        return response()->json($roleNames);
    }

    // Further methods for other operations (read, update, delete) can be added here
}
