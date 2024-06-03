<?php

namespace App\Feature\Branch\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class BranchStoreRequest extends FormRequest
{
    public function rules()
    {
        Log::info('Validating Branch data. REQUEST FILE BEING EXECUTED');

        return [
            'BranchCode' => 'required|unique:Branch',
            'BranchName' => 'required',
            'GSTStateCode' => 'required',
            'BranchType' => 'required',
            'Latitude' => 'required|numeric',
            'Longitude' => 'required|numeric',
            'Country' => 'required',
            'State' => 'required',
            'District' => 'required',
            'Taluka' => 'required',
            'City' => 'required',
            'Status' => 'in:ACTIVE,DEACTIVATED',
            'CreatedBy' => 'nullable|exists:users,id',
            // 'PinCodes' => 'required|numeric',
            'UploadBranch' => 'image|mimes:jpeg,png,jpg|max:2048',
            'UploadShopAct' => 'image|mimes:jpeg,png,jpg|max:2048',
            // 'AssetDeployedList' => 'required',
            'RegionalBranchName' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::error('Branch Validation failed', $validator->errors()->toArray());
        throw new ValidationException($validator);
    }

}