<?php

namespace App\Feature\User\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UserStoreRequest extends FormRequest
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
        Log::debug('Validating new user request data in UserStoreRequest');

        return [
            'tenant_id' => 'required|string',
            'login_id' => 'required|string|max:24|unique:users',
            'mobile_no' => 'required|string|max:10|unique:users',
            'email_id' => 'required|string|email|max:64|unique:users',
            'password_hash' => 'required|string|min:6', // Assuming password is hashed
            'displayname' => 'required|string|max:48',
            'profile_pic_url' => 'nullable',
            'user_type' => 'required|string',
            'role_id' => 'required|string',
            'branch_code' => 'string',
            'status' => 'required|in:ACTIVE,DEACTIVATED',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        Log::error('Validation failed for new user request data in UserStoreRequest', $validator->errors()->toArray());
        parent::failedValidation($validator);
    }
}
