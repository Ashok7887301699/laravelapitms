<?php

namespace App\Feature\CityMaster\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class CityMasterStoreRequest extends FormRequest
{
 public function rules()
{
    return [
        'data.*.CityNameEng' => 'required|string|max:255',
        'data.*.Taluka' => 'required|string|max:255',
        'data.*.District' => 'required|string|max:255',
        
        'data.*.Pincode' => 'required|string|max:255',
        'data.*.Country' => 'required|string|max:255',
        'data.*.State' => 'required|string|max:255',
        'data.*.CityNameMar' => 'required|string|max:255',
        'data.*.CityNameGmap' => 'required|string|max:255',
        'data.*.Latitude' => 'required|string|max:255',
        'data.*.Longitude' => 'required|string|max:255',
        'data.*.Zone' => 'required|string|max:255',
        'data.*.RouteNo' => 'required|string|max:255',
        'data.*.RouteSequens' => 'required|string|max:255',
        'data.*.DelDepot' => 'required|string|max:255',
        'data.*.Tat' => 'required|string|max:255',
        'data.*.ODA' => 'required|string|max:255',
        'data.*.NearStateHighway' => 'required|string|max:255',
        'data.*.NearestNationalHighway' => 'required|string|max:255',
        //'data.*.status' => 'required|string|max:255',
        'data.*.AddUser' => 'required|string|max:255',
    ];



}

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        Log::error('Validation failed', $validator->errors()->toArray());
        throw new ValidationException($validator);
    }
}