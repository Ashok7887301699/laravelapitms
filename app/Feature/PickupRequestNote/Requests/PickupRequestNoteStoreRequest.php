<?php

namespace App\Feature\PickupRequestNote\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PickupRequestNoteStoreRequest extends FormRequest
{
    public function rules()
{
    Log::debug('Validating new pickup request note data in PickupRequestNoteStoreRequest');

    return [     
        
        //Validation rules for  fm_prn table 
        'contact_person_name' => 'required|string|max:255', 
       
        'vehicle_num' => 'required|string|max:255',              

        'created_by' => 'nullable|string|max:255', 

        //Validation rules for fm_prn_lr table

        'prn_lr_data' => 'required|array',
        //'prn_lr_data.*.tenant_id' => 'required|integer', // Ensure it's an array
        //'prn_lr_data.*.prn_id' => 'required|string', // Validate prn_id for each element
        'prn_lr_data.*.lr_id' => 'required|string', 

  
          // Validation rules for fb_lr_state_log table
      //  'prn_lr_data.*.tenant_id' => 'required|integer',
        'prn_lr_data.*.lr_id' => 'required|string|max:255',
        //'prn_lr_data.*.status' => 'required|string|max:255',
      //  'prn_lr_data.*.consignment_location_id' => 'required|string|max:255',
      //  'prn_lr_data.*.total_num_of_pkgs' => 'required|integer',
        'prn_lr_data.*.num_of_pkgs' => 'required|integer',

      //  'prn_lr_data.*.remarks' => 'required|string|max:255',
        //'prn_lr_data.*.state_datetime' => 'required|date_format:Y-m-d H:i:s',
       // 'prn_lr_data.*.state_change_by' => 'required|string|max:255',
        

          // Validation rules for fm_loader_entry
       // 'tenant_id' => 'required|integer',
        'loader_vendor_id' => 'integer',
        //'trip_type' => 'required|string|max:16',
        
        //'action' => 'required|string|max:16',
            
        'total_labour_charges' => 'required|string|max:255',
        //'expense_datetime' => 'required|string|max:255',    
       
    ];
}


    protected function failedValidation(Validator $validator)
    {
        Log::error('Validation failed for new pickup request note data in PickupRequestNoteStoreRequest', $validator->errors()->toArray());
        throw new ValidationException($validator);
    }
}