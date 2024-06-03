<?php

namespace App\Feature\Tenant\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TenantUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        Log::debug('Validating existing tenant update request data in TenantUpdateRequest');

        return [
            // Assuming similar rules as TenantStoreRequest but allowing optional updates
            'name' => 'sometimes|string|max:128',
            'country' => 'sometimes|string|max:64',
            'state' => 'sometimes|string|max:64',
            'city' => 'sometimes|string|max:64',
            // For the 'short_name', ensure it's unique but ignore the current tenant's 'short_name'
            'short_name' => 'sometimes|string|max:10|unique:tenants,short_name,'.$this->tenant,
            'logo_url' => 'sometimes|string|url',
            'description' => 'nullable|string',
            'status' => 'sometimes|in:REGISTERED,ACTIVE,DEACTIVATED',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        Log::error('Validation failed for existing tenant update request data in TenantUpdateRequest', $validator->errors()->toArray());
        throw new ValidationException($validator);
    }
}
