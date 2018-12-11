<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SelectionNewRequest extends FormRequest
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
            //
//            'selection_service' => 'nullable|string',
//            'selection_host' => 'nullable|string',
//            'selection_timeperiod' => 'nullable|string',
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
//            'selection_service.string' => 'A service must be a string',
//            'dateActivation.required' => 'A activation date is required',
        ];
    }

}
