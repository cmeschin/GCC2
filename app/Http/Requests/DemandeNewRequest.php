<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\EtatDemande;
use App\Models\TypeDemande;

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
        /**
         * Récupère les id des valeurs transmises
         */
        
        
        
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
                'refdemande'        => 'required|max:50',
                'dateactivation'    => 'required|date_format:d/m/Y',
                //'listdiffusion'     => 'required|integer',
                //'typedemande_id'    => 'required|integer',
                'prestation'        => 'required|max:100',
                'description'       => 'nullable|string',
        ];
    }
}
