<?php

namespace App\Feature\User\Controllers;

use App\Feature\User\Requests\PrivilegeStoreRequest;
use App\Feature\User\Services\PrivilegeService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Feature\User\Models\Privilege;

class PrivilegeController extends Controller
{
    protected $privilegeService;

    public function __construct(PrivilegeService $privilegeService)
    {
        $this->privilegeService = $privilegeService;
    }

    public function store(PrivilegeStoreRequest $request)
    {
        Log::info('Privilege store method called in PrivilegeController');
        $validatedData = $request->validated();
        $privilege = $this->privilegeService->createPrivilege($validatedData);

        return response()->json($privilege, 201); // 201 Created
    }
    

    public function show($id)
    {
        Log::info('Privilege show method called in PrivilegeController');
        $privilege = $this->privilegeService->getPrivilegeById($id);

        return response()->json($privilege);
    }

    public function index(Request $request)
    {
        Log::info('Privilege index method called in PrivilegeController');
        $privileges = $this->privilegeService->getAllPrivileges($request);

        return response()->json($privileges);
    }

    public function update(Request $request, $id)
    {
        $privilege = $this->privilegeService->updatePrivilege($id, $request->all());

        return response()->json($privilege);
    }

    public function deactivate($id)
    {
        $privilege = $this->privilegeService->deactivatePrivilege($id);
        if ($privilege) {
            $response = $privilege->toArray(); // Convert the Eloquent model to an array
            $response['message'] = 'Privilege deactivated successfully';

            return response()->json($response, 200);
        }

        return response()->json([
            'id' => $id,
            'message' => 'Privilege not found',
        ], 404);
    }

    public function destroy($id)
    {
        if ($this->privilegeService->deletePrivilege($id)) {
            return response()->json([
                'id' => $id,
                'deleted' => true,
                'message' => 'Privilege deleted successfully',
            ], 200);
        }

        return response()->json([
            'id' => $id,
            'message' => 'Privilege not found',
        ], 404);
    }


    public function getPrivileges()
    {
        try {
            // Fetch only name and description fields from the privileges table
            $privileges = Privilege::select('name', 'description')->get();

            // Check if privileges were found
            if ($privileges->isEmpty()) {
                return response()->json(['message' => 'No privileges found'], 404);
            }

            // Return the privileges as JSON response
            return response()->json($privileges, 200);
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json(['error' => 'Failed to fetch privileges'], 500);
        }
    }
    public function getPrivilegeIds()
    {
        $privilegeIds = Privilege::pluck('id')->toArray();
        return response()->json($privilegeIds);
    }
    // Further methods for other operations (read, update, delete) can be added here
}
