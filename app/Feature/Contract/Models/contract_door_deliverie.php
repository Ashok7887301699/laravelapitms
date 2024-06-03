<?php

namespace App\Feature\Contract\Models;

use Illuminate\Database\Eloquent\Model;

class contract_door_deliverie extends Model
{
    // Mass assignable attributes
    protected $fillable = ['contract_id', 'from_place', 'to_place', 'rate'];

    // Relationships
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }
}
