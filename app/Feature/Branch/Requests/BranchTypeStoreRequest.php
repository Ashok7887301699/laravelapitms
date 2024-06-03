<?php

namespace App\Feature\Branch\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class BranchTypeStoreRequest extends FormRequest
{
    public function rules()
    {
        Log::info('Validating Branch data. REQUEST FILE BEING EXECUTED');

        return [
            'tenant_id' => 'integer',
            'branch_type' => 'required|string|max:128',
            'description' => 'required|string|max:255',
            'status' => 'in:ACTIVE,DEACTIVATED',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::error('Branch Validation failed', $validator->errors()->toArray());
        throw new ValidationException($validator);
    }
}
