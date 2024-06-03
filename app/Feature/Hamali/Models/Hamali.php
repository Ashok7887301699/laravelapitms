<?php

namespace App\Feature\Hamali\Models;

use App\Feature\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hamali extends Model
{
    protected $fillable = ['VendorCode','Hvendor','DEPOT','HAccountNO','HIFSC','Hbank','Hbranch','Category','U_Location','status'];

    protected $table ="hamali";
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Other relationships, accessors, and mutators can be added here as needed
}
