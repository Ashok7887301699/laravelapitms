<?php

namespace App\Feature\ProductType\Models;

use App\Feature\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductType extends Model
{
    protected $fillable = ['product_type', 'status'];

    /**
     * Get the users for the tenant.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Other relationships, accessors, and mutators can be added here as needed
}
