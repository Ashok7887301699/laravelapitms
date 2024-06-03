<?php

namespace App\Feature\Ls\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class LsRequests extends FormRequest
{
    public function rules()
    {
        return [
            'dated' => 'date',
            'del_depot' => 'nullable|string|max:255',
            'from_depot' => 'nullable|string|max:255',
            'to_depot' => 'nullable|string|max:255',
            'freight_charges' => 'nullable|numeric',
            'ls_id' => 'string|max:255',
            'ls_lr_data' => 'array',
            'ls_lr_data.*.lr_id' => 'string|max:255',
            'ls_lr_data.*.seq_num' => 'integer',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        // Custom error handling if needed
        throw new ValidationException($validator);
    }
}
