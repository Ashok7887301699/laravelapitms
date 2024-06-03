<?php

namespace App\Feature\Lr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayModel extends Model {
    use HasFactory;
    protected $table = 'contract_payment_types';

    protected $fillable = [
        'contract_paymenttype',
    ];
}


