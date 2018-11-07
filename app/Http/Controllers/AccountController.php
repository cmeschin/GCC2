<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountNewRequest;
use App\Models\Preference;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Account extends Controller
{
    /**
     * Get all preference types
     * @return typepreferences
     */
    public function getTypePreferences()
    {
        $typepreferences = Preference::select('type')->distinct()->get();
        return $typepreferences;
    }

    /**
     * Get all preferences of user by userid
     * @param $userid
     * @return Preference[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllPreferencesByUser($userid)
    {
        $allpreferences = Preference::all('id','type','cle','user_id','valeur')->where('user_id', $userid);
        return $allpreferences;
    }

    /**
     * Add preference to user
     * @param AccountNewRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function addPreference(AccountNewRequest $request)
    {
        $userid = Auth::user()->id;
        $preference = New Preference;

        $preference->user_id    = $userid;
        $preference->type       = $request->typepreference[0];
        $preference->cle        = $request->cle;
        $preference->valeur     = $request->valeur;

        $preference->save();
        return redirect('/moncompte');

    }

    /**
     * Delete preference by id
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delPreference($id)
    {
        $preference = Preference::find($id);
        $preference->delete();
        return redirect('/moncompte');


    }

    /**
     * Get role of user
     * @param $id
     * @return \Illuminate\Support\Collection
     */
    public function isAdmin($id)
    {
        $role = User::where('id',$id)->pluck('role');
        return $role;
    }

}
