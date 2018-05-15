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
                'refdemande'        => 'required|unique:demandes,reference|max:50',
                'dateactivation'    => 'required|date_format:d/m/Y',
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
                'listeDiffusion.required' => 'A ListeDiffusion is required',
                'listeDiffusion.integer' => 'A ListeDiffusion is integer',
                'typeDemande.required'  => 'A typeDemande is required',
                'typeDemande.integer'  => 'A typeDemande is integer',
        ];
    }
}
