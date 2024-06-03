<?php

namespace App\Feature\Contract\Models;

use Illuminate\Database\Eloquent\Model;

class Oda_charge_Model extends Model
{
    protected $table = 'oda_charges';

    protected $fillable = [
        'to_place',
        'oda_charge',
    ];
}
