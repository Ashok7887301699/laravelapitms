<?php
namespace App\Feature\Vehicle\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;


class VehicleRequest extends FormRequest
{
    public function rules()
    {
    Log::info('Validating vehicle data');

    return [

            'VehicleMake' => 'required|string',
            'Model' => 'required|string',
            'Vehicle_No' => 'required|string|unique:vehicles,Vehicle_No',
            'VendorName' => 'VTC 3 PL SERVICES LTD ',
            'VendorType' => 'OWN',
            'Payload' => 'required|string',
            'GVW' => 'required|string',
            'Length' => 'required|string',
            'Width' => 'required|string',
            'Height' => 'required|string',
            'RCBookNo' => 'required|string',
            'RC_Validity' => 'required|date',
            'RegDate' => 'required|date',
            'RegistrationNo' => 'required|string',
            'InsuranceNo' => 'required|string',
            'Insurance_Validity' => 'required|date',
            'AttachedDate' => 'required|date',
            'Fitness_Validity' => 'required|date',
            'Tax_validdity' => 'required|date',
            'Permit_validity' => 'required|date',
            'TaxStatus' => 'required|string',
            'PUCC_Validity' => 'required|date',
            'Chassis_No' => 'required|string',
            'Engine_No' => 'required|string',
            'FuelTankCapacity' => 'required|string',
            'GPSDeviceEnabled' => 'required|string',
            'PermitStates' => 'required|string',
            'NoOfTyres' => 'required|string',
            'FTLType' => 'required|string',
            'RateKm' => 'required|string',
            'StandardMilageKmPerLtr' => 'required|string',
            'ControllingBranch' => 'required|string',
            'Capacity' => 'required|string',
            'UnloadedWeight' => 'required|string',
            'VehicleBroker' => 'required|string',
            'InsuranceCompany' => 'required|string',
            'FitnessCertificateDate' => 'required|date',
            'CertNo' => 'required|string',
            'RTONo' => 'required|string',
            'UploadRc' => 'required|string',
            'UploadInsuarance' => 'required|string',
            'UploadPermit' => 'required|string',
            'UploadPUC' => 'required|string',
            'Permit_No' => 'nullable|string',
            'Fitness_No' => 'nullable|string',
            'CloseTrip' => 'required|string',
            'ActiveFlag' => 'required|string',
            'MilageKM' => 'nullable|string',
            'Milage' => 'required|string',

    ];



}

protected function failedValidation(Validator $validator)
{
    Log::error('Validation failed', $validator->errors()->toArray());
    throw new ValidationException($validator);
}
}
