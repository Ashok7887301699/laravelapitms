<?php

namespace App\Feature\India\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class IndiaStoreRequest extends FormRequest
{
    public function rules()
    {
        Log::debug('Validating new India request data in IndiaStoreRequest');

        return [
           
            'Country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'taluka' => 'required|string|max:255',
            'postoffice' => 'required|string|max:255',
            'post_pincode' => 'required|string|max:255',
            'status' => 'required|string|in:ACTIVE,DEACTIVATED',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::error('Validation failed for new india request data in IndiaStoreRequest', $validator->errors()->toArray());
        throw new ValidationException($validator);
    }
}
