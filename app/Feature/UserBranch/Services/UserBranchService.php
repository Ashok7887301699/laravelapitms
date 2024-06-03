<?php

namespace App\Feature\UserBranch\Services;

use App\Feature\UserBranch\Models\UserBranch;
use App\Feature\UserBranch\Repositories\UserBranchRepository;
use Illuminate\Support\Facades\Log;

class UserBranchService
{
    protected $userbranchRepository;

    public function __construct(UserBranchRepository $userbranchRepository)
    {
        $this->userbranchRepository = $userbranchRepository;
    }

    public function createUserBranch(array $data)
    { 
        return $this->userbranchRepository->create($data);
    }

    public function getUserBranchById($user_id)
{
    // Assuming UserBranch model has a column named 'user_id'
    return UserBranch::where('user_id', $user_id)->get();
}

    public function getAllUserBranchs($request)
    {
        $query = UserBranch::query();

        // Filter by 'name'
        if ($request->has('user_id')) {
            $query->where('user_id', 'like', '%' . $request->user_id . '%');
        }
        if ($request->has('branch_code')) {
            $query->where('branch_code', 'like', '%' . $request->branch_code . '%');
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



    public function updateUserBranch($user_id, array $data)
    {
        $userbranch = $this->userbranchRepository->find($user_id);

        if ($userbranch) {
            $userbranch->update($data);
        }

        return $userbranch;
    }

    public function deactivateUserBranch($user_id)
    {
        $userbranch = $this->userbranchRepository->find($user_id);
        if ($userbranch) {
            $userbranch->update(['status' => 'DEACTIVATED']);

            return $userbranch;
        }

        return null; // Handle the case where the role is not found
    }

    public function deleteUserBranch($user_id)
    {
        $userbranch = $this->userbranchRepository->find($user_id);

        if ($userbranch) {
            // Delete the role
            $userbranch->delete();

            return true;
        }

        return false;
    }
}
