<?php

namespace App\Feature\Drs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FuelVendordata extends Model
{
    use HasFactory;

    protected $table = 'vendorfuel';
    protected $primaryKey = 'id';

    protected $fillable = [
        'PetrolPumpName',
    ];

    
}
