<?php

namespace App\Feature\Contract\Models;

use Illuminate\Database\Eloquent\Model;

class ContractExcessWeight extends Model
{
    // Mass assignable attributes
    protected $fillable = ['contract_id', 'lower_slab_limit', 'upper_slab_limit', 'rate'];

    // Relationships
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }
}
