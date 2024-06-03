<?php

namespace App\Feature\User\Controllers;

use App\Feature\User\Requests\UserStoreRequest;
use App\Feature\User\Requests\UserUpdateRequest;
use App\Feature\User\Services\UserService;
use App\Http\Controllers\Controller;
use App\Feature\User\Models\Role;
use App\Feature\Tenant\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Feature\Branch\Models\Branch;
use App\Feature\UserBranch\Models\UserBranch;


class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        Log::debug("User index method called in UserController");

        //TODO: Add all other field names which shall be used for search filter in the line below.
        $filters = $request->only(['active', 'created_from', 'created_to', 'updated_from', 'updated_to', 'login_id', 'tenant_id', 'displayname', 'user_type', 'status', 'role_id']);
        $sortBy = $request->get('sort_by', 'updated_at'); // Default sort by 'updated_at'
        $sortOrder = $request->get('sort_order', 'desc'); // Default sort order
        $perPage = $request->get('per_page', 10); // Default items per page

        try {
            $users = $this->userService->getAllUsers($filters, $sortBy, $sortOrder, $perPage);
            return response()->json($users);
        } catch (\Exception $e) {
            Log::error('Error in UserController@index: ' . $e->getMessage());
            return response()->json(['message' => 'Error fetching data'], 500);
        }
    }
    public function store(UserStoreRequest $request)
    {
        Log::debug('User store method called in UserController');
        $validatedData = $request->validated();
        Log::info("Before try");
        try {

            // Map role name to ID
            $role = Role::where('name', $validatedData['role_id'])->firstOrFail();
            Log::info(" role is getting");

            // Map tenant short name to ID
            $tenant = Tenant::where('short_name', $validatedData['tenant_id'])->firstOrFail();
            Log::info(" tenant is getting");

            // Hash password
            $validatedData['password_hash'] = bcrypt($validatedData['password_hash']);

            // File Upload Logic for profile_pic_url
            $profilePic = $request->file('profile_pic_url');
            // Ensure a file is uploaded before proceeding
            if ($profilePic) {
                $profilePicPath = $profilePic->store('public/profile_pics');

                // Prepend the URL path with Laravel's storage path
                $profilePicUrl = asset('storage/' . str_replace('public/', '', $profilePicPath));
            } else {
                // If no file uploaded, set profile pic URL to null
                $profilePicUrl = null;
            }

            Log::info(" Profile pic is getting");


            // Prepare data for insertion into users table excluding branch_code
            $userData = [
                'role_id' => $role->id,
                'tenant_id' => $tenant->id,
                'login_id' => $validatedData['login_id'],
                'mobile_no' => $validatedData['mobile_no'],
                'email_id' => $validatedData['email_id'],
                'password_hash' => $validatedData['password_hash'],
                'displayname' => $validatedData['displayname'],
                'profile_pic_url' => $profilePicUrl,
                'user_type' => $validatedData['user_type'],
                'status' => $validatedData['status'],
                'updated_at' => now(),
                'created_at' => now(),
            ];

            Log::info(" userData is getting");


            // Create user and retrieve the created user
            $user = $this->userService->createUser($userData);
            Log::info("adding usr ");

            // Check if branch code is provided and store it in the userbranch table
            if ($request->has('branch_code')) {
                $branchCode = $request->input('branch_code');
                Log::info("Branch code getting succes");
                Log::debug($branchCode);

                // Store user-branch association in the userbranch table
                UserBranch::create([
                    'user_id' => $user->id,
                    'branch_code' => $branchCode,
                    'status' => 'ACTIVE', // Assuming a default status
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Log requested data
            Log::info("Requested data:", $userData);

            return response()->json(['user' => $user], 201);
        } catch (\Exception $e) {
            Log::error('Failed to create User in UserController@store: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to create user. Please check the provided role_id and tenant_id.'], 500);
        }
    }




    // public function store(UserStoreRequest $request)
    // {
    //     Log::debug('User store method called in UserController');
    //     $validatedData = $request->validated();

    //     try {
    //         // Map role name to ID
    //         $role = Role::where('name', $validatedData['role_id'])->firstOrFail();

    //         // Map tenant short name to ID
    //         $tenant = Tenant::where('short_name', $validatedData['tenant_id'])->firstOrFail();

    //         // Hash password
    //         $validatedData['password_hash'] = bcrypt($validatedData['password_hash']);

    //         // File Upload Logic for profile_pic_url
    //         $profilePic = $request->file('profile_pic_url');
    //         // Ensure a file is uploaded before proceeding
    //         if ($profilePic) {
    //             $profilePicPath = $profilePic->store(
    //                 'public/profile_pics'
    //             );

    //             // Prepend the URL path with the Laravel's storage path
    //             $profilePicUrl = asset('storage/' . str_replace('public/', '', $profilePicPath));
    //         } else {
    //             // If no file uploaded, set profile pic URL to null
    //             $profilePicUrl = null;
    //         }

    //         // Prepare data for insertion into users table
    //         $data = [
    //             'role_id' => $role->id,
    //             'tenant_id' => $tenant->id,
    //             'login_id' => $validatedData['login_id'],
    //             'mobile_no' => $validatedData['mobile_no'],
    //             'email_id' => $validatedData['email_id'],
    //             'password_hash' => $validatedData['password_hash'],
    //             'displayname' => $validatedData['displayname'],
    //             'profile_pic_url' => $profilePicUrl,
    //             'user_type' => $validatedData['user_type'],
    //             'status' => $validatedData['status'],
    //             'updated_at' => now(),
    //             'created_at' => now(),
    //         ];

    //         // Create user
    //         $user = $this->userService->createUser($data);
    //         log::info("requested data:-", $data);
    //         return response()->json(['user' => $user], 201);
    //     } catch (\Exception $e) {
    //         Log::error('Failed to create User in UserController@store: ' . $e->getMessage());
    //         return response()->json(['message' => 'Failed to create user. Please check the provided role_id and tenant_id.'], 500);
    //     }
    // }



    //     public function store(UserStoreRequest $request)
// {
//     Log::debug('User store method called in UserController');
//     $validatedData = $request->validated();

    //     try {
//         // Map role name to ID
//         $role = Role::where('name', $validatedData['role_id'])->firstOrFail();

    //         // Map tenant short name to ID
//         $tenant = Tenant::where('short_name', $validatedData['tenant_id'])->firstOrFail();

    //         // Hash password
//         $validatedData['password_hash'] = bcrypt($validatedData['password_hash']);

    //         // File Upload Logic for profile_pic_url
//         $profilePic = $request->file('profile_pic_url');
//         // Ensure a ,file is uploaded before proceeding
//         if ($profilePic) {
//             $profilePicFilename = $validatedData['login_id'] . '_' . now()->format('Ymd') . '_' . uniqid() . '.' . $profilePic->getClientOriginalExtension();
//             Storage::makeDirectory('public/profile_pics');
//             $profilePicPath = $profilePic->storeAs(
//                 'public/profile_pics',
//                 $profilePicFilename
//             );

    //             // Prepend asset() function to generate a complete URL
//             $profilePicUrl = asset(str_replace('public/', '', $profilePicPath));
//         } else {
//             // If no file uploaded, set profile pic URL to null
//             $profilePicUrl = null;
//         }

    //         // Prepare data for insertion into users table
//         $data = [
//             'role_id' => $role->id,
//             'tenant_id' => $tenant->id,
//             'login_id' => $validatedData['login_id'],
//             'mobile_no' => $validatedData['mobile_no'],
//             'email_id' => $validatedData['email_id'],
//             'password_hash' => $validatedData['password_hash'],
//             'displayname' => $validatedData['displayname'],
//             'profile_pic_url' => $profilePicUrl,
//             'user_type' => $validatedData['user_type'],
//             'status' => $validatedData['status'],
//             'updated_at' => now(),
//             'created_at' => now(),
//         ];

    //         // Create user
//         $user = $this->userService->createUser($data);
//         log::info("requested data:-",$data);
//         return response()->json(['user' => $user], 201);
//     } catch (\Exception $e) {
//         Log::error('Failed to create User in UserController@store: ' . $e->getMessage());
//         return response()->json(['message' => 'Failed to create user. Please check the provided role_id and tenant_id.'], 500);
//     }
// }


    public function show($id)
    {
        Log::info('User show method called in userController');
        $user = $this->userService->getUserById($id);

        return response()->json($user);
    }
    public function update(UserUpdateRequest $request, $id)
    {
        Log::debug("User update method called in UserController for ID: $id");
        $validatedData = $request->validated();

        try {
            $user = $this->userService->updateUser($id, $validatedData);
            if (!$user) {
                return response()->json(['message' => 'User not found or update not possible'], 404);
            }
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Update failed: ' . $e->getMessage()], 500);
        }
    }


    public function deactivate($id)
    {
        Log::debug("Deactivating User with ID: $id in UserController");
        $user = $this->userService->deactivateUser($id);

        if ($user) {
            return response()->json(['id' => $id, 'active' => false, 'message' => 'User deactivated successfully'], 200);
        } else {
            return response()->json(['message' => 'User not found or already deactivated'], 404);
        }
    }

    public function destroy($id)
    {
        Log::debug("Attempting to delete User with ID: $id in UserController");
        if ($this->userService->deleteUser($id)) {
            return response()->json(['id' => $id, 'deleted' => true, 'message' => 'User deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
    public function getProfilePhoto($id)
    {
        $user = $this->userService->getUserById($id);

        if (!$user || !$user->profile_pic_url) {
            abort(404);
        }

        $profilePicPath = str_replace('storage', 'public', $user->profile_pic_url);

        return response()->file(storage_path($profilePicPath));
    }
    // public function fetchdeponame()
    // {
    //     // Call the depot_code method from your service
    //     $BranchCode = $this->userService->depot_code();

    //     // Check if BranchCodes are not empty
    //     if (!empty($BranchCode)) {
    //         // Return the fetched BranchCodes
    //         return response()->json(['BranchCode' => $BranchCode], 200);
    //     } else {
    //         // Return an error message if BranchCodes are not found
    //         return response()->json(['message' => 'BranchCode not found'], 404);
    //     }
    // }

}
