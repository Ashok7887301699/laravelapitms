<?php
namespace App\Feature\Lr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lrdata extends Model {
    use HasFactory;

    protected $table = 'fb_lr';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'tenant_id',
        'booking_user_id',
        'consignor_id',
        'consignor_name',
        'consignor_addr',
        'consignor_gst',
        'consignee_gst',
        'consignor_mobile',
        'freight_rate_per_kg',
        'total_freight_charges',
        'insurance_rate',
        'other_charges',
        'docu_charges',
        'excess_weight_charges',
        'truck_load_type',
        'del_speed',
        'pickup_del_type',
        'freight_rate_type',
        'door_del_charges',
        'sgst_amnt',
        'oda_charges',
        'payment_type',
        'consignee_type',
        'consignee_id',
        'consignee_name',
        'consignee_mobile',
        'cost_center_id',
        'from_place',
        'to_place',

        'truck_load_type',
        'del_speed',
        'pickup_del_type',
        'freight_rate_type',
        'status',
        'edited_by',
        'canceled_by',
 
        'return_booked_by',

    ];
}