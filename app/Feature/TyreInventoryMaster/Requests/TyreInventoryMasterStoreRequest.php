<?php

namespace App\Feature\TyreInventoryMaster\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class TyreInventoryMasterStoreRequest extends FormRequest
{
    public function rules()
    {
        Log::info('Validating Tyre Inventory Master data');

        return [
            // 'tyre_code' => 'required|string', // Add new field
            'tyre_number' => 'required|string', // Add new field
            'tyre_category' => 'required|string', // Add new field
            'manufacturer' => 'required|string', // Add new field
            'tyre_size' => 'required|string', // Add new field
            'tyre_pattern' => 'required|string', // Add new field
            'purchase_date' => 'required|date', // Add new field
            'qty' => 'required|numeric', // Add new field
            'price' => 'required|numeric', // Add new field
            'tyre_type' => 'required|string', // Add new field
            'tyre_position' => 'required|string', // Add new field
            'tyre_weight' => 'required|numeric', // Add new field
            'tyre_status' => 'required|string|in:Brand New,In Use,Scrap', // Add new field
            'status' => 'string|in:ACTIVE,DEACTIVATED',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::error('Validation failed', $validator->errors()->toArray());
        throw new ValidationException($validator);
    }
}
