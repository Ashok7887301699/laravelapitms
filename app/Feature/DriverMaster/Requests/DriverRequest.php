<?php

namespace App\Feature\DriverMaster\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class DriverRequest extends FormRequest
{
    public function rules()
    {
        Log::info('Validating Driver data');

        return [
            'FirstName' => 'required',
            'MiddleName' => 'required',
            'LastName' => 'required',
            'SAPId' => 'nullable',
            'UserId' => 'nullable|exists:users,id',
            'BranchCode' => 'nullable',
            'DriverCode' => 'required|unique:drivers,DriverCode',
            'Location' => 'required',
            'MobileNumber' => 'required|numeric|digits:10|unique:drivers,MobileNumber',
            'PermanentAddress' => 'required',
            'CurrentAddress' => 'required',
            'LicenseNumber' => 'required|unique:drivers,LicenseNumber',
            'LicenseValidity' => 'required',
            'IssuedByRTO' => 'required',
            'FirstLicenseIssueDate' => 'required',
            'CloseTrip' => 'required|boolean',
            'DriverFatherName' => 'required',
            'VehicleNumber' => 'required|unique:drivers,VehicleNumber',
            'PermanentCity' => 'required',
            'PermanentPincode' => 'required|integer',
            'CurrentCity' => 'required',
            'CurrentPincode' => 'required|integer',
            'GuarantorName' => 'required',
            'Status' => 'in:ACTIVE,DEACTIVATED,DELETED',
            'DriverCategory' => 'required',
            'DOB' => 'required',
            'DOJ' => 'required',
            'Ethinicity' => 'required',
            'CurrentLicenseIssueDate' => 'required',
            'LicenseVerifiedDate' => 'required',
            'LicenseVerified' => 'required',
            // 'VerifiedByUserId' => 'nullable|exists:users,id',
            'AddressVerified' => 'required',
            'DriverPhoto' => 'image|mimes:jpeg,png,jpg|max:2048',
            'PanCard' => 'image|mimes:jpeg,png,jpg|max:2048',
            'VoterId' => 'image|mimes:jpeg,png,jpg|max:2048',
            'AadharCard' => 'image|mimes:jpeg,png,jpg|max:2048',
            'License' => 'image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::error('Driver Validation failed', $validator->errors()->toArray());
        throw new ValidationException($validator);
    }

}