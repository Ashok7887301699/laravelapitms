<?php

namespace App\Feature\Ls\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FbConsignmentDetail extends Model
{
    use HasFactory;

    protected $table = 'fb_consignment';
    // public $incrementing = false;
    protected $primaryKey = 'lr_id';

    protected $fillable = [
        'lr_id',
        'num_of_pkgs',
        'actual_weight_per_pkg',
    ];
}
