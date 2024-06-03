<?php

namespace App\Feature\Contract\Services;

use App\Feature\Contract\Repositories\Oda_charge_Repository;

class Oda_charge_Service
{
    protected $Oda_charge_Repository;

    public function __construct(Oda_charge_Repository $Oda_charge_Repository)
    {
        $this->Oda_charge_Repository = $Oda_charge_Repository;
    }

    public function createodacharge(array $data)
    {
        return $this->Oda_charge_Repository->create($data);
    }

    public function getAllodacharge()
    {
        return $this->Oda_charge_Repository->getAllEoda();
    }

    public function getodachargebyid($id)
    {
        return $this->Oda_charge_Repository->findodacharge($id);
    }

    public function updateodachargeId($id, array $data)
    {
        $service = $this->Oda_charge_Repository->findodacharge($id);
        if ($service) {
            $service->update($data);
        }

        return $service;
    }
}
