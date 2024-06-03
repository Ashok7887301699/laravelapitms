<?php

namespace App\Feature\Contract\Models;

use Illuminate\Database\Eloquent\Model;
use App\Feature\Tenant\Models\Tenant;
use App\Feature\User\Models\User;

class Contract extends Model
{
    // Mass assignable attributes
    protected $fillable = ['contract_id','tenant_id', 'sap_cust_code', 'start_date', 'end_date', 'status', 'created_by'];

    // Relationships
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function customerGrp()
    {
        return $this->belongsTo(CustomerGrp::class, 'customer_grp_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }



    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function contractServices()
    {
        return $this->hasMany(ContractServices::class);
    }

    public function contractSlabDefinitions()
    {
        return $this->hasMany(ContractSlabDefinition::class);
    }

    public function contractSlabRates()
    {
        return $this->hasMany(ContractSlabRates::class);
    }

    public function contractExcessWeights()
    {
        return $this->hasMany(ContractExcessWeight::class);
    }
    public function Doordelivery()
    {
        return $this->hasMany(contract_door_deliverie::class);
    }
}
