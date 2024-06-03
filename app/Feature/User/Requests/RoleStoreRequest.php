<?php

namespace App\Feature\User\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class RoleStoreRequest extends FormRequest
{
    public function rules()
    {
        Log::info('Validating Role data');

        return [
            //'tenant_id' => 'string',
            'name' => 'required|string', 
            'description' => 'required|string', 
            'status' => 'string|in:ACTIVE,DEACTIVATED','BLOCKED', // Validation for status
            'privilege_names.*' => 'string',  // Validation for privilege_name
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::error('Validation failed', $validator->errors()->toArray());
        throw new ValidationException($validator);
    }
}
