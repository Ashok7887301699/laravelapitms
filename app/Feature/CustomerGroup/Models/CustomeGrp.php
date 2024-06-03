<?php

namespace App\Feature\CustomerGroup\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Feature\Customer\Models\Customer;

class CustomerGrp extends Model
{
    protected $primaryKey = 'cust_grp_code';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['cust_grp_code', 'name', 'logo_url', 'status'];


   // Relationships
    public function customers()
    {
        return $this->hasMany(Customer::class, 'cust_grp_code', 'cust_grp_code');
    }
}
