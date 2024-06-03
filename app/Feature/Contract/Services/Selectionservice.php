<?php

namespace App\Feature\Contract\Services;

use App\Feature\Contract\Repositories\ServiceRepository;

class SelectionService
{
    protected $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function createService(array $data)
    {
        // Additional ServiceRepository logic before saving can go here
        return $this->serviceRepository->create($data);
    }

    public function getAllServices()
    {
        return $this->serviceRepository->getAll();
    }

    public function getServiceById($contract_id)
    {
        return $this->serviceRepository->find($contract_id);
    }

    public function updateServiceById($contract_id, array $data)
    {
        $service = $this->serviceRepository->find($contract_id);
        if ($service) {
            $service->update($data);
        }

        return $service;
    }
}
