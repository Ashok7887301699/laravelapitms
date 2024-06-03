<?php

namespace App\Feature\PickupRequestNote\Models;

use App\Feature\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;


class fm_loader_expense extends Model
{
    use HasFactory;

    protected $table = 'fm_loader_expense';
    public $incrementing = false;

    protected $fillable = [
        'tenant_id',
        'loader_vendor_id',
        'trip_type',
        'trip_id',
        'action',
        'office_depot_id',
        'loading_unloading_rate_1',
        'num_of_packages_1',
        'loading_unloading_rate_2',
        'num_of_packages_2',
        'total_labour_charges',
        'expense_datetime',
        'expense_booked_in_tp',
        'payment_txn_id_from_tp',
        'payment_datetime_from_tp',
     
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}