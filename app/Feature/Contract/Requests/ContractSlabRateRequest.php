<?php

namespace App\Feature\Contract\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class ContractSlabRateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'contract_id' => 'required|string|max:255',
            'zone' => 'required|string|max:255',
            'from_place' => 'required|string|max:255',
            'to_place' => 'required|string|max:255',
            'transit_tat' => 'required|string|max:255',
            'slab1' => 'required|string|max:255',
            'slab2' => 'required|numeric',
            'slab3' => 'required|string|max:255',
            'slab4' => 'required|string|max:255',
            'slab5' => 'required|string|max:255',
            'slab6' => 'required|string|max:255',
            'slab7' => 'required|string|max:255',
            'slab8' => 'required|string|max:255',
            'slab_contract_type' => 'required|string|max:255',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::error('Validation failed', $validator->errors()->toArray());
        throw new ValidationException($validator);
    }
}
