<?php

namespace App\Feature\Vehicle\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vehcpctmodel extends Model{
    use HasFactory;
    protected $table = 'vehiclecapacitymodel';

    protected $fillable = [
        'vehcpctmodel',
        'vehiclecpct',
    ];
}
