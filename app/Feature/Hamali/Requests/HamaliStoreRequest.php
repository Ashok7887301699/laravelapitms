<?php

namespace App\Feature\Hamali\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class HamaliStoreRequest extends FormRequest
{
    public function rules()
    {
        Log::info('Validating Hamali data');

        return [
            'VendorCode' => 'required|string|unique:hamali,VendorCode',
            'Hvendor' => 'required|string|unique:hamali,Hvendor',
            'DEPOT' => 'required|string',
            'HAccountNO' => 'required|string',
            'HIFSC' => 'required|string',
            'Hbank' => 'required|string',
            'Hbranch' => 'required|string',
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
