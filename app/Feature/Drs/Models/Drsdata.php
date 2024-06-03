<?php

namespace App\Feature\Drs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Drsdata extends Model
{
    use HasFactory;

    protected $table = 'fm_drs';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'tenant_id',
        'dated',
        'del_depot',
        'fleet_vendor_id',
        'vehicle_model_by_capacity',
        'vehicle_num',
        'trip_distance_km_est',
        'vehicle_meter_reading_trip_start',
        'vehicle_meter_reading_trip_end',
        'driver_name',
        'driver_mobile',
        'dl_num',
        'dl_expiry_datetime',
        'consolidated_ewb_num',
        'trip_start_date',
        'trip_end_date',
        'status',
        'cancellation_reason',
        'pod_datetime',
        'created_by',
        'pod_received_by'
    ];

    
}
