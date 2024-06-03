<?php

namespace App\Feature\Vehicle\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $primaryKey = 'Vehicle_No';
    public $incrementing = false;

    protected $fillable = [
       'SrNo', 'VehicleMake', 'Model', 'Vehicle_No', 'VendorName', 'VendorType', 'Payload', 'GVW', 'Length', 'Width', 'Height',
        'RCBookNo', 'RC_Validity', 'RegDate', 'RegistrationNo', 'InsuranceNo', 'Insurance_Validity', 'AttachedDate', 'Fitness_Validity', 'Permit_validity',
        'Tax_validdity', 'TaxStatus', 'PUCC_Validity', 'Chassis_No', 'Engine_No', 'FuelTankCapacity', 'GPSDeviceEnabled', 'PermitStates', 'NoOfTyres',
        'FTLType', 'RateKm', 'StandardMilageKmPerLtr', 'ControllingBranch', 'Capacity', 'UnloadedWeight', 'VehicleBroker', 'InsuranceCompany',
        'FitnessCertificateDate', 'CertNo', 'RTONo', 'UploadRc', 'UploadInsuarance', 'UploadPermit', 'UploadPUC', 'Permit_No', 'Fitness_No',
        'CloseTrip', 'ActiveFlag', 'MilageKM', 'Milage'
    ];

    // Optionally, you can define relationships or additional methods here
}
