<?php

namespace App\Feature\ProductType\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class ProductTypeStoreRequest extends FormRequest
{
    public function rules()
    {
        Log::info('Validating producttype data');

        return [
            'product_type' => 'required|string|unique:product_types,product_type', // Validation for product_type
            'status' => 'string|in:ACTIVE,DEACTIVATED', // Validation for status
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::error('Validation failed', $validator->errors()->toArray());
        throw new ValidationException($validator);
    }
}
