<?php

namespace App\Feature\PackageType\Models;

use App\Feature\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PackageType extends Model
{
    protected $fillable = ['package_type','status'];



    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Other relationships, accessors, and mutators can be added here as needed
}
