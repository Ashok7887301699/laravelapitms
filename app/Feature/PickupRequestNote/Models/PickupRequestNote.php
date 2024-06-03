<?php

namespace App\Feature\PickupRequestNote\Models;

use App\Feature\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PickupRequestNote extends Model
{
    use HasFactory;

    protected $table = 'fm_prn';
    public $incrementing = false;

    

    protected $fillable = [   
        'id',          
        'tenant_id',
        'booking_office_id',
        'pickupaddress',       
        'contact_person_name',
        'contact_person_mobile1',
        'contact_person_mobile2',
        'pickup_datetime',
        'receiving_depot_id',
        'vehicle_model_by_capacity',
        'vehicle_num',
        'trip_distance_km_est',
        'freight_charges', 
        'vehicle_meter_reading_trip_start',
        'vehicle_meter_reading_trip_end',
        'driver_vendor_id',
        'driver_name',        
        'dl_num',
        'dl_expiry_datetime',      
        'hamalivendorname',
        'hamalivendoramount',
        'arrivalhamalivendorname',
        'arrivalhamalivendoramount',
        'consolidated_ewb_num',
        'trip_start_date',        
        'trip_end_date',
        'status',      
        'cancellation_reason',
        'cancellation_date',
        'canceled_by',
        'depot_arrival_datetime',
        'created_by',
        'depot_received_by'    
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}