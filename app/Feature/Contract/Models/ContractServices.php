<?php

namespace App\Feature\Contract\Models;

use Illuminate\Database\Eloquent\Model;

class ContractServices extends Model
{
    // Mass assignable attributes
    protected $fillable = ['contract_id', 'load_type', 'rate_type', 'slab_contract_type', 'matrices_type', 'pickup_delivery_mode', 'doc_charges', 'excess_weight_chargeable', 'door_delivery_chargeable','insurance_chargeable','minimum_excess'];

    // Relationships
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }
}
