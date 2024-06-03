<?php

namespace App\Feature\Tenant\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TenantStoreRequest extends FormRequest
{
    public function rules()
    {
        Log::debug('Validating new tenant request data in TenantStoreRequest');

        return [
            'name' => 'required|string|max:128',
            'country' => 'required|string|max:64',
            'state' => 'required|string|max:64',
            'city' => 'required|string|max:64',
            'short_name' => 'required|string|max:10|unique:tenants',
            'logo_url' => 'required|string|url',
            'description' => 'nullable|string',
            'status' => 'required|in:REGISTERED,ACTIVE,DEACTIVATED',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::error('Validation failed for new tenant request data in TenantStoreRequest', $validator->errors()->toArray());
        throw new ValidationException($validator);
    }
}
