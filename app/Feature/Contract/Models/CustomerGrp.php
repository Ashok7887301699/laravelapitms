<?php

namespace App\Feature\Contract\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerGrp extends Model
{
    // Mass assignable attributes
    protected $fillable = ['name'];

    // Relationships
    public function contracts()
    {
        return $this->hasMany(Contract::class, 'customer_grp_id');
    }
}
