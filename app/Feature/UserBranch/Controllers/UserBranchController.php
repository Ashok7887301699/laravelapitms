<?php

namespace App\Feature\UserBranch\Controllers;

use App\Feature\UserBranch\Requests\UserBranchStoreRequest;
use App\Feature\UserBranch\Services\UserBranchService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Feature\User\Models\User;
use App\Feature\Branch\Models\Branch;
use Illuminate\Support\Facades\Log;

class UserBranchController extends Controller
{
    protected $userbranchService;

    public function __construct(UserBranchService $userbranchService)
    {
        $this->userbranchService = $userbranchService;
    }

    public function store(UserBranchStoreRequest $request)
{
    Log::info('User store method called in RolePrivilegeController');

    // Retrieve user by ID
    $user = User::where('login_id', $request->input('user_id'))->first();
        if (!$user) {
            return response()->json(['error' => 'user not found'], 404);
        }

        // Map privilege name to ID
        $branch = Branch::where('BranchCode', $request->input('branch_code'))->first();
        if (!$branch) {
            return response()->json(['error' => 'branch not found'], 404);
        }

    // Prepare data for insertion
    $data = [
        'user_id' => $user->id, // Assuming 'id' is the primary key in the 'users' table
        'branch_code' => $branch, // Use the provided branch code directly
        'updated_at' => now(),
        'created_at' => now(),
    ];

    // Insert into userbranch table
    $userbranch = $this->userbranchService->createUserBranch($data);

    return response()->json($userbranch, 201); // 201 Created
}

    public function show($user_id)
    {
        Log::info(' UserBranch show method called in RolePrivilegeController');
        $userbranch = $this->userbranchService->getUserBranchById($user_id);

        return response()->json($userbranch);
    }

    public function index(Request $request)
    {
        Log::info('user branchindex method called in RolePrivilegeController');
        $userbranch = $this->userbranchService->getAllUserBranchs($request);

        return response()->json($userbranch);
    }

    public function update(Request $request, $user_id)
    {
        $userbranch = $this->userbranchService->updateUserBranch($user_id, $request->all());

        return response()->json($userbranch);
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

    public function destroy($user_id)
    {
        if ($this->userbranchService->deleteUserBranch($user_id)) {
            return response()->json([
                'user_id' => $user_id,
                'deleted' => true,
                'message' => 'User Branch deleted successfully',
            ], 200);
        }

        return response()->json([
            'user_id' => $user_id,
            'message' => 'RolePrivilege not found',
        ], 404);
    }

    // Further methods for other operations (read, update, delete) can be added here
}
