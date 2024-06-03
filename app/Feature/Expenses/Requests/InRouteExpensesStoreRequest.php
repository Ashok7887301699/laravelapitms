<?php

namespace App\Feature\Expenses\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class InRouteExpensesStoreRequest extends FormRequest
{
    public function rules()
    {
        Log::info('Validating Expenses data in InRouteExpensesStoreRequest');

        return [
            'tenant_id' => 'integer',
            'name_of_expenses' => 'required|string|max:128',
            'description' => 'required|string|max:255',
            'status' => 'in:ACTIVE,DEACTIVATED',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
        ];
    }

    protected function failedValidation($validator)
    {
        Log::error('Expenses Validation failed', $validator->errors()->toArray());
        throw new \Illuminate\Validation\ValidationException($validator);
    }
}
