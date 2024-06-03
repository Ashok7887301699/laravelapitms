<?php

namespace App\Feature\Lr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lrfetchdata extends Model
{
    use HasFactory;

    protected $table = 'fb_consignment';

    // Define fillable fields if necessary
    protected $fillable = [
        'lr_id',
        'invoice_num',
        'invoice_date',
        'pkg_type',
        'product_type',
        'invoice_value',
        'num_of_pkgs',
        'actual_weight_per_pkg',
        'total_actual_weight',
        'total_av_weight',
    ];
}