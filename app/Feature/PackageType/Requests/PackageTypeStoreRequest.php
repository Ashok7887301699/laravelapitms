<?php

namespace App\Feature\PackageType\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class PackageTypeStoreRequest extends FormRequest
{
    public function rules()
    {
        Log::info('Validating packagetype data');

        return [
            'package_type' => 'required|string|unique:package_types,package_type',
            'status' => 'required|string|in:ACTIVE,DEACTIVATED',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::error('Validation failed', $validator->errors()->toArray());
        throw new ValidationException($validator);
    }
}
