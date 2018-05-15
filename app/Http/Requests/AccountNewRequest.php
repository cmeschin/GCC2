<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AccountNewRequest extends FormRequest
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
                /**
                 * Traitement des nouvelles préférence
                 * Valider les données avant de les insérer en base
                 * @type type de préference
                 * @nom nom de la préférence
                 * @valeur valeur de la préférence
                 * 
                 */
                
                
                'typepreference'      => 'required|exists:preferences,type',
                'cle'       => Rule::unique('preferences')->where(function ($query) {
                    return $query->where('user_id', Auth::user()->id);
                        }),
               'valeur'    => 'email_array',
                
        ];
    }
    
//     /**
//      * Get the error messages for the defined validation rules.
//      *
//      * @return array
//      */
//     public function messages()
//     {
//         return [
//                 'cle.required' => 'A Nom is required',
//                 'valeur.required'  => 'A Valeur is required',
//         ];
//     }
}
