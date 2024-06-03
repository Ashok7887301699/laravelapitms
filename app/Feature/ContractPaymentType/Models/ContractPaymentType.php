<?php

namespace App\Feature\ContractPaymentType\Models;

use App\Feature\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContractPaymentType extends Model
{
    protected $fillable = ['contract_paymenttype', 'status'];

    /**
     * Get the users for the ContractPaymentType.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Other relationships, accessors, and mutators can be added here as needed
}
