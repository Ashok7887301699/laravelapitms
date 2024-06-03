<?php

namespace App\Feature\Contract\Models;

use Illuminate\Database\Eloquent\Model;

class ContractSlabRates extends Model
{
    // Mass assignable attributes
    protected $fillable = ['contract_id', 'zone', 'from_place', 'to_place', 'transit_tat', 'slab_contract_type', 'slab1', 'slab2', 'slab3', 'slab4', 'slab5', 'slab6', 'slab7', 'slab8', 'slab_contract_type'];

    // Relationships
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }
}
