<?php

namespace App\Feature\VendorFuel\Models;

use App\Feature\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VendorFuel extends Model
{
    protected $fillable = ['PetrolPumpName','Vendorname','DVendorCode','Depot','status'];
    
    protected $table = "vendorfuel";
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Other relationships, accessors, and mutators can be added here as needed
}
