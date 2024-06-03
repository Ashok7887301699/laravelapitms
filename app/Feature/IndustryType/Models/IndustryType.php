<?php

namespace App\Feature\IndustryType\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Feature\Customer\Models\Customer;

class IndustryType extends Model
{
    protected $fillable = ['name', 'description', 'status'];


   // Relationships
    public function customers()
    {
        return $this->hasMany(Customer::class, 'ind_type_id', 'id');
    }
}
