<?php

namespace App\Feature\India\Models;

use App\Feature\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class India extends Model
{
    protected $table = 'india';

    protected $fillable = ['Country', 'state', 'district', 'taluka', 'postoffice', 'post_pincode', 'status'];

    /**
     * Get the users for the India.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Other relationships, accessors, and mutators can be added here as needed
}
