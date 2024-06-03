<?php

namespace App\Feature\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RolePrivilege extends Model
{
    protected $fillable = ['role_id', 'privilege_id', 'status'];

    /**
     * Get the role associated with the role_privilege.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the privilege associated with the role_privilege.
     */
    public function privilege(): BelongsTo
    {
        return $this->belongsTo(Privilege::class);
    }
}
