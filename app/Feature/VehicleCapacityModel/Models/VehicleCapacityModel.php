<?php

namespace App\Feature\VehicleCapacityModel\Models;

use App\Feature\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleCapacityModel extends Model
{
    protected $fillable = ['vehcpctmodel','vehiclecpct','modeldesc','status'];

    protected $table = "vehiclecapacitymodel";
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Other relationships, accessors, and mutators can be added here as needed
}
