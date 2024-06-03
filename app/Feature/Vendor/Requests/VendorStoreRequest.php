<?php

namespace App\Feature\Vendor\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class VendorStoreRequest extends FormRequest
{
    public function rules()
    {
        Log::info('Validating Vendor data');

        return [
            'VendorCode' => 'required|string|unique:vendor,VendorCode',
            'VendorName' => 'required|string||unique:vendor,VendorName',
            'Type' => 'required|string',
            'Address' => 'required|string',
            'City' => 'required|string',
            'Depot' => 'required|string',
            'Vehicle' => 'required|string',
            'Pincode' => 'required|string',
            'Mobile_No' => 'required|string',
            'Email' => 'required|string',
            'PAN_No' => 'required|string',
            'GSTNO' => 'required|string',
            'BankName' => 'required|string',
            'AccountNO' => 'required|string',
            'IFSC' => 'required|string',
            'Category' => 'required|string',
            'U_Location' => 'required|string',
            'status' => 'required|string|in:ACTIVE,DEACTIVATED',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::error('Validation failed', $validator->errors()->toArray());
        throw new ValidationException($validator);
    }
}
