<?php

namespace App\Feature\Vendor\Models;

use App\Feature\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
{
    protected $fillable = ['VendorCode','VendorName','Type','AccountNO','IFSC','BankName','Address','Depot','City','Vehicle','Pincode','Mobile_No','Email','Category','U_Location','PAN_No','GSTNO','status'];

    protected $table ="vendor";
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Other relationships, accessors, and mutators can be added here as needed
}
