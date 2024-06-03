<?php

namespace App\Feature\Ls\Repositories;

use App\Feature\Ls\Models\Ls;
use App\Feature\Ls\Models\LsLr;

class LsRepository
{
    // public function createLs(array $data): Ls
    // {
    //     // Create and return a new Ls model
    //     return Ls::create($data);
    // }

    // public function createLsLr(array $data): LsLr
    // {
    //     // Create and return a new LsLr model
    //     return LsLr::create($data);
    // }

    public function create(array $data): Ls
    {
        // Create and return a new PickupRequestNote model
        return Ls::create($data);
    }

    public function find($id): ?Ls
    {
        // Return null if the record is not found
        return Ls::find($id);
    }


}
