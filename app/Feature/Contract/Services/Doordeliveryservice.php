<?php

namespace App\Feature\Contract\Services;
use App\Feature\Contract\Repositories\Doordeliveryrepository;

class Doordeliveryservice 
{
    protected $Doordeliveryrepository;
    public function __construct(Doordeliveryrepository $Doordeliveryrepository)
    {
        $this->Doordeliveryrepository=$Doordeliveryrepository;
    }
    public function createdoordeliver($data)
    {
        return $this->Doordeliveryrepository->create($data);
    }
    public function getAllDoordeliverys()
    {
        return $this->Doordeliveryrepository->getAll();
    }
    public function getratesById($contract_id)
    {
        return $this->Doordeliveryrepository->findrates($contract_id);
    }

    public function updateratesById(array $dataArray, $contract_id)
    {
        $updatedEntries = [];
    
        foreach ($dataArray as $data) {
            // Update each entry with the contract ID
            $updatedEntry = $this->Doordeliveryrepository->update($data, $contract_id);
            $updatedEntries[] = $updatedEntry;
        }
    
        return $updatedEntries;
    }

}