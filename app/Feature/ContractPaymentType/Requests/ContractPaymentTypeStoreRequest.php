<?php

namespace App\Feature\ContractPaymentType\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class ContractPaymentTypeStoreRequest extends FormRequest
{
    public function rules()
    {
        Log::info('Validating contractpaymenttype data');

        return [
            'contract_paymenttype' => 'required|string|unique:contract_payment_types,contract_paymenttype',
            'status' => 'required|string|in:ACTIVE,DEACTIVATED',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::error('Validation failed', $validator->errors()->toArray());
        throw new ValidationException($validator);
    }
}
