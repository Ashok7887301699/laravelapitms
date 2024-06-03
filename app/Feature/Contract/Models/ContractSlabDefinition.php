<?php

namespace App\Feature\Contract\Models;

use Illuminate\Database\Eloquent\Model;

class ContractSlabDefinition extends Model
{
    // Mass assignable attributes
    protected $fillable = ['contract_id','slab_number', 'slab_lower_limit', 'slab_upper_limit', 'slab_contract_type', 'slab_rate_type'];

    // Relationships
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }
}
