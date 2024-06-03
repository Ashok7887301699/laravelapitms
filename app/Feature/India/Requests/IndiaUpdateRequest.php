<?php

namespace App\Feature\India\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class IndiaUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        Log::debug('Validating existing india update request data in IndiaUpdateRequest');

        return [
         

            'Country' => 'sometimes|string|max:255',
            'state' => 'sometimes|string|max:255',
            'district' => 'sometimes|string|max:255',
            'taluka' => 'string|max:255',
            'postoffice' => 'sometimes|string|max:255',
            'post_pincode' => 'sometimes|string|max:255',
            'status' => 'sometimes|string|in:ACTIVE,DEACTIVATED',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        Log::error('Validation failed for existing india update request data in IndiaUpdateRequest', $validator->errors()->toArray());
        throw new ValidationException($validator);
    }
}
