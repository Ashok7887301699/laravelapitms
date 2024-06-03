<?php

namespace App\Feature\User\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class PrivilegeStoreRequest extends FormRequest
{
    public function rules()
    {
        Log::info('Validating Privilege data');

        return [
            //'tenant_id' => 'string',
            'name' => 'required|string', 
            'description' => 'required|string', 
            'status' => 'string|in:ACTIVE,DEACTIVATED', // Validation for status
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::error('Validation failed', $validator->errors()->toArray());
        throw new ValidationException($validator);
    }
}
