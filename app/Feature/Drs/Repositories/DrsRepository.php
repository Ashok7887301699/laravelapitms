<?php

namespace App\Feature\Drs\Repositories;

use App\Feature\Drs\Models\Drs;
use App\Feature\Drs\Models\DrsLr;

class DrsRepository
{
    public function create(array $data)
    {
        return Drs::create($data);
    }

    public function findDrsById($id): ?Drs
    {
        return Drs::find($id);
    }

}
