<?php

namespace App\Feature\Contract\Services;

use App\Feature\Contract\Repositories\ExcessRepository;

class ExcessWeightService
{
    protected $excessRepository;

    public function __construct(ExcessRepository $excessRepository)
    {
        $this->excessRepository = $excessRepository;
    }


    public function createExcess(array $dataArray)
    {
        
    $createdEntries = [];

    foreach ($dataArray as $data) {
        // Additional ServiceRepository logic before saving can go here
        $createdEntries[] = $this->excessRepository->create($data);
    }

    return $createdEntries;
    }

    public function getAllExcessweight(){
        return $this->excessRepository->getAllExcessweight();
    }
    public function getexcessById($contract_id)
    {
        return $this->excessRepository->findexcess($contract_id);
    }
    public function updateExcessById($id, array $data)
    {
        $service = $this->excessRepository->findexcess($id);
        if ($service) {
            $service->update($data);
        }

        return $service;
    }

}
