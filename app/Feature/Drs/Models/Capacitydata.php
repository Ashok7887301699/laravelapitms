<?php

namespace App\Feature\Drs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Capacitydata extends Model
{
    use HasFactory;

    protected $table = 'vehiclecapacitymodel';
    protected $primaryKey = 'id';

    protected $fillable = [
        'vehcpctmodel',
    ];

    
}
