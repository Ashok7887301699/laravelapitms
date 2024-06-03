<?php

namespace App\Feature\UserBranch\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Feature\User\Models\User;
use App\Feature\Branch\Models\Branch;

class UserBranch extends Model
{
    protected $table = 'userbranch';
    protected $fillable = ['user_id', 'branch_code', 'status'];

    /**
     * Get the role associated with the userbranch.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the privilege associated with the userbranch.
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
