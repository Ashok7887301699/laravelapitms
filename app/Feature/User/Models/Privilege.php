<?php

namespace App\Feature\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Privilege extends Model
{
    protected $fillable = ['name', 'description', 'status'];

    /**
     * The roles that have the privilege.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_privileges');
    }
}
