<?php

namespace App\Feature\Lr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class fb_lrfetchdata extends Model
{
    protected $table = 'fb_lr';


    protected $fillable = [
        'to_place', 'payment_type', 'consignee_name', 'consignee_addr',
        'consignee_mobile', 'docu_charges', 'freight_rate_type', 'Status', 'origin_depot_id', 'del_speed',
        'pickup_del_type', 'other_charges', 'door_del_charges', 'expected_del_date',
        'excess_weight_charges', 'docket_total_charges', 'cgst_rate', 'cgst_amnt', 'created_at', 'delivered_at'
    ];
}
