<?php

namespace App\Feature\VehicleCapacityModel\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class VehicleCapacityModelStoreRequest extends FormRequest
{
    public function rules()
    {
        Log::info('Validating VehicleCapacityModel data');

        return [
            //'tenant_id' => 'string',
            'vehcpctmodel' => 'required|string|unique:vehiclecapacitymodel,vehcpctmodel',
            'vehiclecpct'  => 'required|string',
            'modeldesc' => 'required|string', 
            'status' => 'string|in:ACTIVE,DEACTIVATED', // Validation for status
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::error('Validation failed', $validator->errors()->toArray());
        throw new ValidationException($validator);
    }
}
