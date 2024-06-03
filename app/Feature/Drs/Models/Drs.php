<?php

namespace App\Feature\Drs\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Drs extends Model
{
    protected $table = 'fm_drs'; 
   
    
    protected $keyType = 'string'; 
    
    public $incrementing = false;
    
    protected $fillable = [
        'id',  
        'tenant_id',
        'dated',
        'del_depot',
        'fleet_vendor_id',
        'vehicle_model_by_capacity',
        'vehicle_num',
        'trip_distance_km_est',
        'freight_charges',
        'vehicle_meter_reading_trip_start',
        'vehicle_meter_reading_trip_end',
        'driver_vendor_id',
        'driver_name',
        'driver_mobile',
        'dl_num',
        'dl_expiry_datetime',
        'num_of_lrs',
        'consolidated_ewb_num',
        'trip_start_date',
        'trip_end_date',
        'status',
        'cancellation_reason',
        'pod_datetime',
        'created_by',
        'pod_received_by',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'dated' => 'datetime',
        'dl_expiry_datetime' => 'datetime',
        'trip_start_date' => 'datetime',
        'trip_end_date' => 'datetime',
        'pod_datetime' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function podReceivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pod_received_by');
    }

    public function depot(): BelongsTo
    {
        return $this->belongsTo(DepotSeeder::class, 'del_depot');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(VendorSeeder::class, 'fleet_vendor_id');
    }

   

    
}
