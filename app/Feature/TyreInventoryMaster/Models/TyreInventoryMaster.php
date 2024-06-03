<?php

namespace App\Feature\TyreInventoryMaster\Models;

use App\Feature\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TyreInventoryMaster extends Model
{
    protected $fillable = ['tyre_code', 'tyre_number', 'tyre_category', 'manufacturer', 'tyre_size', 'tyre_pattern', 'purchase_date', 'qty', 'price', 'tyre_type', 'tyre_position', 'tyre_weight', 'tyre_status', 'status'];

    protected $table ="tyre_inventory_master";
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Other relationships, accessors, and mutators can be added here as needed
}