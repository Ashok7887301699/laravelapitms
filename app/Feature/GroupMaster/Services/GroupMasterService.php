<?php

namespace App\Feature\GroupMaster\Services;

use App\Feature\GroupMaster\Models\GroupMaster;
use App\Feature\GroupMaster\Repositories\GroupMasterRepository;
use Illuminate\Support\Facades\Log;

class GroupMasterService
{
    protected $groupmasterRepository;

    public function __construct(GroupMasterRepository $groupmasterRepository)
    {
        $this->groupmasterRepository = $groupmasterRepository;
    }

    public function createGroupMaster(array $data)
    {
        $data['groupcode'] = strtoupper($data['groupcode']);
        $data['groupname'] = strtoupper($data['groupname']);  
        return $this->groupmasterRepository->create($data);
    }

    public function getGroupMasterById($id)
    {
        return $this->groupmasterRepository->find($id);
    }

    public function getAllGroupMasters($request)
    {
        $query = GroupMaster::query();

        // Filter by 'name'
        if ($request->has('groupcode')) {
            $query->where('groupcode', 'like', '%' . $request->groupcode . '%');
        }

        if ($request->has('groupname')) {
            $query->where('groupname', 'like', '%' . $request->groupname . '%');
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



    public function updateGroupMaster($id, array $data)
    {
        $groupmaster = $this->groupmasterRepository->find($id);

        if ($groupmaster) {
            $groupmaster->update($data);
        }

        return $groupmaster;
    }

    public function deactivateGroupMaster($id)
    {
        $groupmaster = $this->groupmasterRepository->find($id);
        if ($groupmaster) {
            $groupmaster->update(['status' => 'DEACTIVATED']);

            return $groupmaster;
        }

        return null; // Handle the case where the groupmaster is not found
    }

    public function deleteGroupMaster($id)
    {
        $groupmaster = $this->groupmasterRepository->find($id);

        if ($groupmaster) {
            // Delete the groupmaster type
            $groupmaster->delete();

            return true;
        }

        return false;
    }
}
