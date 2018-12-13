<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountNewRequest;
use App\Models\Preference;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Get All accounts
     * @return mixed
     */
    public function getAllAccounts()
    {
        $allAccounts = User::all('id','username','name','email','role','created_at');
        return $allAccounts;
    }
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
     * @param $userid, $preferenceid
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delPreference($userid,$preferenceid)
    {
        $preference = Preference::find($preferenceid);
        $preference->delete();
        return redirect('/moncompte');
    }

    /**
     * Set account role
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function setAccount($userid)
    {
        $user = User::find($userid);
        if ($user->role == "admin")
        {
            $role    = "user";
        } else
        {
            $role    = "admin";
            //dd($user->role,$role);
        }

        $user->role = $role;
        $user->save();
        return redirect('/accounts');
    }

    /**
     * Del account
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delAccount($userid)
    {
        $user = User::find($userid);
        $user->delete();
        return redirect('/accounts');
    }
    /**
     * Get role of user
     * @param $id
     * @return \Illuminate\Support\Collection
     */
    public function isAdmin($userid)
    {
        $role = User::where('id',$userid)->pluck('role');
        return $role;
    }

}
