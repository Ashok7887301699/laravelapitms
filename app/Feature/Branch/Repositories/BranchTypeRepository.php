<?php

namespace App\Feature\Branch\Repositories;

use App\Feature\Branch\Models\BranchType;

class BranchTypeRepository
{
    public function create(array $data): BranchType
    {
        return BranchType::create($data);
    }

    // public function findByBranchCode($BranchCode)
    // {
    //     return BranchType::where('BranchCode', $BranchCode)->first();
    // }

    public function find($id)
    {
        return BranchType::find($id);
    }

    public function delete($id)
    {
        $branchType = BranchType::find($id);
        if ($branchType) {
            return $branchType->delete();
        }
        return false;
    }
}
