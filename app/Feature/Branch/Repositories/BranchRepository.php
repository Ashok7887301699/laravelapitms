<?php

namespace App\Feature\Branch\Repositories;

use App\Feature\Branch\Models\Branch;
use Illuminate\Support\Arr;

class BranchRepository
{
    public function create(array $data): Branch
    {
        return Branch::create($data);
    }

    public function findByBranchCode($BranchCode)
    {
        return Branch::where('BranchCode', $BranchCode)->first();
    }
}