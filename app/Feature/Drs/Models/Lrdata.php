<?php

namespace App\Feature\Drs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lrdata extends Model
{
    use HasFactory;

    protected $table = 'lr';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'custom_lr_num', 'lr_ref_num', 'tenant_id', 'booking_office_id', 'booking_date_time', 'booking_user_id',
        'consignor_type', 'consignor_group_id', 'consignor_id', 'consignor_name', 'consignor_addr', 'consignor_mobile',
        'consignor_email', 'consignor_gst', 'consignor_name_mar', 'consignor_addr_mar', 'payment_type', 'consignee_type',
        'consignee_id', 'consignee_name', 'consignee_addr', 'consignee_mobile', 'consignee_email', 'consignee_gst',
        'consignee_name_mar', 'consignee_addr_mar', 'billing_party_id', 'cost_center_id', 'from_place', 'to_place_type',
        'to_place', 'to_place_zone', 'origin_depot_id', 'del_depot_id', 'truck_load_type', 'del_speed', 'pickup_del_type',
        'expected_del_date', 'total_num_of_invoices', 'total_value_of_invoices', 'total_num_of_pkgs', 'total_weight_in_kgs',
        'freight_rate_type', 'freight_rate_per_kg', 'freight_rate_per_pkg', 'excess_weight_charges', 'total_freight_charges',
        'total_excess_weight_charges', 'docu_charges', 'load_unload_charges', 'door_del_charges', 'oda_charges',
        'insurance_rate', 'other_charges', 'sgst_rate', 'cgst_rate', 'sgst_amnt', 'cgst_amnt', 'docket_total_charges',
        'status', 'edited_at', 'edited_by', 'canceled_at', 'cancellation_reason', 'canceled_by', 'return_booked_on',
        'return_lr_id', 'return_booked_by', 'delivered_at', 'created_at', 'updated_at'
    ];
    

    
}
