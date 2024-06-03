<?php

namespace App\Feature\Contract\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class ContractStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'tenant_id' => 'required',
            'sap_cust_code'=> 'required',
            'status' => 'required',
            'created_by' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::error('Validation failed', $validator->errors()->toArray());
        throw new ValidationException($validator);
    }
}
