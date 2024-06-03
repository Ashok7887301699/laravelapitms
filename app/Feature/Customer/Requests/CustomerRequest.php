<?php

namespace App\Feature\Customer\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class CustomerRequest extends FormRequest
{
    public function rules()
    {
        Log::info('Validating customer data');

        return [
            'data' => 'required|array', // Ensure 'data' key is present and is an array
            'data.*.sap_cust_code' => 'required|string|max:64',
            'data.*.sap_cust_grp_code' => 'required|string|max:64',
            'data.*.CostCenter' => '',
            'data.*.CustName' => 'required|string|max:128',
            'data.*.Category' => 'required|string',
            'data.*.MobileNo' => 'required|string|max:15',
            'data.*.PAN' => 'required|string|max:64',
            'data.*.GST_No' => 'required|string|max:64',
            'data.*.City' => 'required|string|max:64',
            'data.*.Pincode' => 'required|string|max:10',
            'data.*.Location' => 'required|string|max:128',
            'data.*.TelNo' => 'required|string|max:15',
            'data.*.Address' => 'required|string|max:255',
            'data.*.sap_ind_type' => 'string|max:255', // Adjust as needed
            'data.*.CustNameMar' => 'string|max:255', // Adjust as needed
            'data.*.AddressMar' => 'string|max:255', // Adjust as needed
            'data.*.BillAddressMar' => 'string|max:255', // Adjust as needed
            'data.*.BillingMail' => 'email|max:255', // Adjust as needed
            'data.*.BillingMobileNo' => 'required|string|max:15',
            'data.*.BiillingPerson' => 'required|string|max:128',
            'data.*.Status' => 'required|string|in:1,0',
            'data.*.sap_depot_name' => 'string|max:128', // Adjust as needed
            'data.*.CreatedBy' => 'required|string|max:64',
            'data.*.SalesReference' => 'required|string|max:64',
            'data.*.sap_create_date' => 'required|date',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::error('Validation failed', $validator->errors()->toArray());
        throw new ValidationException($validator);
    }
}
