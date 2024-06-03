<?php

namespace App\Feature\User\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // TODO: Update authorization logic if necessary
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        Log::debug('Validating user update request data in UserUpdateRequest');

        $userId = $this->route('id');

        return [
            'tenant_id' => 'sometimes|exists:tenants,id',
            'login_id' => 'sometimes|string|max:24|unique:users,login_id,' . $userId,
            'mobile_no' => 'sometimes|string|max:16|unique:users,mobile_no,' . $userId,
            'email_id' => 'sometimes|string|email|max:64|unique:users,email_id,' . $userId,
            'password_hash' => 'sometimes|string|min:6',
            'displayname' => 'sometimes|string|max:48',
            'profile_pic_url' => 'nullable',
            'user_type' => 'sometimes|string',
            'role_id' => 'nullable|exists:roles,id',
            'status' => 'sometimes|in:REGISTERED,ACTIVE,DEACTIVATED,BLOCKED',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        Log::error('Validation failed for user update request data in UserUpdateRequest', $validator->errors()->toArray());
        parent::failedValidation($validator);
    }
}