<?php

namespace App\Feature\Contract\Models;

use Illuminate\Database\Eloquent\Model;

class groupmaster extends Model
{
    // Mass assignable attributes
    protected $fillable = ['groupname','groupcode'];

    // Relationships
    public function contracts()
    {
        return $this->hasMany(Contract::class, 'customer_grp_id');
    }
}
