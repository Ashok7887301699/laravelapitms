<?php

namespace App\Feature\GroupMaster\Models;

use App\Feature\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GroupMaster extends Model
{
    protected $fillable = ['groupcode','groupname','status'];

    protected $table = "groupmaster";
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Other relationships, accessors, and mutators can be added here as needed
}
