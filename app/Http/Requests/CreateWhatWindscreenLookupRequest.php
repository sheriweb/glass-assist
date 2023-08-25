<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWhatWindscreenLookupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
           'vehicle_registration_number' => 'required',
           'vin_number' => 'required',
           'vehicle_make' => 'required',
           'vehicle_model' => 'required',
           'vehicle_year_manufacture' => 'required',
           'glass_position' => 'required',
        ];
    }
}
