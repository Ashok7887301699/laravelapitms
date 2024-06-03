<?php

namespace App\Feature\Lr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productModel extends Model
{
    use HasFactory;

    protected $table = 'product_types';

    protected $fillable = [
        'product_type',
    ];
}