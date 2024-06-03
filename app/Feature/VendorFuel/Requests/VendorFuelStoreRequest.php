<?php

namespace App\Feature\VendorFuel\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class VendorFuelStoreRequest extends FormRequest
{
    public function rules()
    {
    Log::info('Validating vendorfuel data');

    return [
        'PetrolPumpName' => 'required|string|unique:vendorfuel,PetrolPumpName',
        'Vendorname' => 'required|string|unique:vendorfuel,Vendorname',
        'DVendorCode' => 'required|string|unique:vendorfuel,DVendorCode',
        'Depot' => 'required|string',
        'status' => 'required|string|in:ACTIVE,DEACTIVATED',
    ];
    
    }


    protected function failedValidation(Validator $validator)
    {
        Log::error('Validation failed', $validator->errors()->toArray());
        throw new ValidationException($validator);
    }
}
