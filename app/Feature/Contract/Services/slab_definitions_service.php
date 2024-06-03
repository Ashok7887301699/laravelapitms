<?php

namespace App\Feature\Contract\Services;

use App\Feature\Contract\Repositories\slab_definitions_repository;

class slab_definitions_service
{
    protected $slab_definitions_repository;

    public function __construct(slab_definitions_repository $slab_definitions_repository)
    {
        $this->slab_definitions_repository = $slab_definitions_repository;
    }

    public function createslab_definition($data)
    {
        return $this->slab_definitions_repository->create($data);
    }
    public function getAllslab()
    {
        return $this->slab_definitions_repository->getAll();
    }
    public function getidbyslab($id)
    {
        return $this->slab_definitions_repository->getslabbyid($id);
    }
    public function updateslabById($id, array $data)
    {
        $service = $this->slab_definitions_repository->getslabbyid($id);
        if ($service) {
            $service->update($data);
        }

        return $service;
    }
}
