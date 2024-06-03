<?php

namespace App\Feature\Drs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicledata extends Model
{
    use HasFactory;

    protected $table = 'vehicles';
    protected $primaryKey = 'id';
    protected $fillable = [
        'VendorName',
    ];

    public static function getVehicleNoByVendorName($vendorName)
    {
        $vehicleNos = static::where('VendorName', $vendorName)->pluck('Vehicle_No')->toArray();
        return $vehicleNos;
    }
}
