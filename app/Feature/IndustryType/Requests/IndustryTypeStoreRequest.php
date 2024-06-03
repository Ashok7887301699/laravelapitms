<?php

namespace App\Feature\IndustryType\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class IndustryTypeStoreRequest extends FormRequest
{
    public function rules()
    {
        Log::info('Validating industrytype data');

        return [
            'name' => 'required|string|unique:industry_types,name',
            'description' => 'required|string',
            'status' => 'required|string|in:ACTIVE,DEACTIVATED',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::error('Validation failed', $validator->errors()->toArray());
        throw new ValidationException($validator);
    }
}
