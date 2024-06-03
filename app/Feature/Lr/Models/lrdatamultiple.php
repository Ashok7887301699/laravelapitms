<?php
namespace App\Feature\Lr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lrdatamultiple extends Model {
    use HasFactory;

    protected $table = 'fb_consignment';

    protected $fillable = [
        'tenant_id',
        'lr_id',
        'invoice_num',
        'invoice_date',
        'pkg_type',
        'Product_type',
        'invoice_value',
        'num_of_pkgs',
        'actual_weight_per_pkg',
        'total_actual_weight',
   
        
    ];
}
