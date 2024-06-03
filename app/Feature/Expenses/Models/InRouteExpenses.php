<?php

namespace App\Feature\Expenses\Models;
use App\Feature\User\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InRouteExpenses extends Model
{
    use HasFactory;

    protected $table = 'md_in_route_expenses';

    protected $fillable = [
        'tenant_id',
        'name_of_expenses',
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

