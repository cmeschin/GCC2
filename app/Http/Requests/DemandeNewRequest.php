<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DemandeNewRequest extends FormRequest
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
             * Traitement des informations générales
             * Valider les données avant de les insérer en base
             * @refdemande => reference
             * @typedemande_id
             * @etatdemande
             * @user_id
             * @prestation
             * @listediffusion_id
             * @dateactivation => date_activation
             * @description => commentaire
             */
                
                
                //'etat'    => 'required|exists:etat_demandes,etat',
                'demandeur'         => 'required|exists:users,username',
                'refDemande'        => 'required|unique:demandes,reference|max:50',
                'dateActivation'    => 'required|date_format:d/m/Y',
                //'listeDiffusion'     => 'required|integer',
                //'typeDemande'    => 'required|integer',
                'prestation'        => 'required|max:100',
                'description'       => 'nullable|string',
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
                'prestation.required' => 'A prestation is required',
                'dateActivation.required' => 'A activation date is required',
        ];
    }
}
