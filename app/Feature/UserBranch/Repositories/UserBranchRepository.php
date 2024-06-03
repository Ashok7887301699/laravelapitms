<?php

namespace App\Feature\UserBranch\Repositories;

use App\Feature\UserBranch\Models\UserBranch;

class UserBranchRepository
{
    public function create(array $data): UserBranch
    {
        $data['status'] = $data['status'] ?? 'ACTIVE';
        // Create and return a new UserBranch model
        return UserBranch::create($data);
    }

    
    public function find(array $compositeKey)
    {
        // Assuming $compositeKey is an associative array with keys ['user_id', 'branch_code']
        return UserBranch::where('user_id', $compositeKey['user_id'])
                            ->where('branch_code', $compositeKey['branch_code'])
                            ->first();
    }


   
}
