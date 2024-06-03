<?php

namespace App\Feature\Branch\Models;
use App\Feature\User\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BranchType extends Model
{
    use HasFactory;

    protected $table = 'md_branch_type';

    protected $fillable = [
        'tenant_id',
        'branch_type',
        'description',
        'status',
        'created_by',
        'updated_by',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Define relationships as needed
}
