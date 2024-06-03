<?php

namespace App\Feature\GroupMaster\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class GroupMasterStoreRequest extends FormRequest
{
    public function rules()
    {
        Log::info('Validating GroupMaster data');

        return [
            //'tenant_id' => 'string',
            'groupcode' => 'required|string|unique:groupmaster,groupcode',
            'groupname'  => 'required|string',
            'status' => 'string|in:ACTIVE,DEACTIVATED', // Validation for status
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::error('Validation failed', $validator->errors()->toArray());
        throw new ValidationException($validator);
    }
}
