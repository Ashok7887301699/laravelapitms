<?php

namespace App\Feature\Contract\Repositories;

use App\Feature\Contract\Models\Oda_charge_Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Oda_charge_Repository
{
    public function create(array $data): Oda_charge_Model
    {
        return Oda_charge_Model::create($data);
    }

    public function getAllEoda()
    {
        return Oda_charge_Model::all();
    }

    public function findodacharge($id)
    {
        try {
            return Oda_charge_Model::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return null;
        }
    }
}
