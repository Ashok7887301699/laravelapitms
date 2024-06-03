<?php

namespace App\Feature\Contract\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Excessrequest extends FormRequest
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
     */public function rules()
        {
            return [
                'contract_id' => 'required',
                'lower_slab_limit' => 'required',
                'upper_slab_limit' => 'required',
                'rate' => 'required',
            ];
        }

}
