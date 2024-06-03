<?php

namespace App\Feature\UserBranch\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class UserBranchStoreRequest extends FormRequest
{
    public function rules()
    {
        Log::info('Validating UserBranch data');

        return [
            //'tenant_id' => 'string',
            'user_id' => 'required|string', 
            'branch_code' => 'required|string', 
            'status' => 'string|in:ACTIVE,DEACTIVATED', // Validation for status
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::error('Validation failed', $validator->errors()->toArray());
        throw new ValidationException($validator);
    }
}
