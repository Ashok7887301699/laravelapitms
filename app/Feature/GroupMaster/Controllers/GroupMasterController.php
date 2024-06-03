<?php

namespace App\Feature\GroupMaster\Controllers;

use App\Feature\GroupMaster\Requests\GroupMasterStoreRequest;
use App\Feature\GroupMaster\Services\GroupMasterService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GroupMasterController extends Controller
{
    protected $groupmasterService;

    public function __construct(GroupMasterService $groupmasterService)
    {
        $this->groupmasterService = $groupmasterService;
    }

    public function store(GroupMasterStoreRequest $request)
    {
        Log::info('GroupMaster store method called in GroupMasterController');
        $validatedData = $request->validated();
        $groupmaster = $this->groupmasterService->createGroupMaster($validatedData);

        return response()->json($groupmaster, 201); // 201 Created
    }
    

    public function show($id)
    {
        Log::info('GroupMaster show method called in GroupMasterController');
        $groupmaster = $this->groupmasterService->getGroupMasterById($id);

        return response()->json($groupmaster);
    }

    public function index(Request $request)
    {
        Log::info('GroupMaster index method called in GroupMasterController');
        $groupmasters = $this->groupmasterService->getAllGroupMasters($request);

        return response()->json($groupmasters);
    }

    public function update(Request $request, $id)
    {
        $groupmaster = $this->groupmasterService->updateGroupMaster($id, $request->all());

        return response()->json($groupmaster);
    }

    public function deactivate($id)
    {
        $groupmaster = $this->groupmasterService->deactivateGroupMaster($id);
        if ($groupmaster) {
            $response = $groupmaster->toArray(); // Convert the Eloquent model to an array
            $response['message'] = 'GroupMaster deactivated successfully';

            return response()->json($response, 200);
        }

        return response()->json([
            'id' => $id,
            'message' => 'GroupMaster not found',
        ], 404);
    }

    public function destroy($id)
    {
        if ($this->groupmasterService->deleteGroupMaster($id)) {
            return response()->json([
                'id' => $id,
                'deleted' => true,
                'message' => 'GroupMaster deleted successfully',
            ], 200);
        }

        return response()->json([
            'id' => $id,
            'message' => 'GroupMaster not found',
        ], 404);
    }

    // Further methods for other operations (read, update, delete) can be added here
}
