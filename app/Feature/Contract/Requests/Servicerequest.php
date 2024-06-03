<?php

namespace App\Feature\Contract\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Servicerequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // You can implement your authorization logic here if needed
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'contract_id' => 'required|exists:contracts,contract_id',
            'load_type' => 'required',
            'rate_type' => 'required',
            'slab_contract_type' => 'required',
            'matrices_type' => 'required|in:City-City,City-District,City-Taluka,City-Pincode',
            'pickup_delivery_mode' => 'required',
            'doc_charges' => 'required|numeric',
            'excess_weight_chargeable' => 'required|boolean',
            'door_delivery_chargeable' => 'required|boolean',
            'insurance_chargeable' => 'required|numeric',
            'minimum_excess' => 'required|numeric',
        ];
    }
}
