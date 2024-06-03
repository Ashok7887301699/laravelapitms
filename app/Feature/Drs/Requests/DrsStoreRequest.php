<?php

namespace App\Feature\Drs\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class DrsStoreRequest extends FormRequest
{
    public function rules()
    {
        // Log information about validating DRS data
        Log::info('Validating Drs data');

        // Define validation rules for storing DRS
        return [
            'tenant_id' => 'nullable|integer', 
            'dated' => 'nullable|date', 
            'del_depot' => 'nullable|string|max:16',
            'fleet_vendor_id' => 'nullable|integer', 
            'vehicle_model_by_capacity' => 'nullable|string|max:32',
            'vehicle_num' => 'required|string|max:16',
            'trip_distance_km_est' => 'nullable|numeric',
            'vehicle_meter_reading_trip_start' => 'nullable|integer', 
            'vehicle_meter_reading_trip_end' => 'nullable|integer', 
            'driver_name' => 'required|string|max:32',
            'driver_mobile' => 'required|string|max:16', 
            'freight_charges' => 'numeric|regex:/^\d{0,8}(\.\d{1,2})?$/',
            'dl_num' => 'required|string|max:24', // String for driver license number
            'dl_expiry_datetime' => 'nullable|date', // Date for driver license expiry
            'consolidated_ewb_num' => 'nullable|string|max:16', // Nullable string for consolidated EWB number
            'trip_start_date' => 'nullable|date', // Date for trip start
            'trip_end_date' => 'nullable|date', // Date for trip end
            'status' => 'in:1,0,NONE',
            'cancellation_reason' => 'nullable|in:reason_value_1,reason_value_2,reason_value_3,NONE', // Nullable string for cancellation reason
            'pod_datetime' => 'nullable|date', // Nullable date for POD datetime
            'created_by' => 'nullable|string|max:255', // String for created by (user ID)
            'pod_received_by' => 'nullable|string|max:255', // Nullable string for POD received by (user ID)
            'drs_data' => 'array',
            'drs_data.*.tenant_id' => 'integer', // Ensure it's an array
            'drs_data.*.drs_id' => 'string', // Validate prn_id for each element
            'drs_data.*.lr_id' => 'string', 
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Log validation errors if validation fails
        Log::error('Validation failed', $validator->errors()->toArray());
        
        // Throw a ValidationException if validation fails
        throw new ValidationException($validator);
    }
}
