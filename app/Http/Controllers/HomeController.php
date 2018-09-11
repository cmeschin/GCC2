<?php

namespace App\Http\Controllers;

use App\Models\Preference;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AccountNewRequest;

//use App\Models\User;
//use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
        if (! auth()->check()) {
            return redirect('/login');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = $this->isAdmin(Auth::user()->id)->get(0);
        return view('home', compact('role'));
    }

    public function account()
    {
//        if (! auth()->check()) {
//            return redirect('/login');
//        }
        $typepreferences = $this->getTypePreferences();
        $allpreferences = $this->getAllPreferencesByUser(Auth::user()->id);
        
        return view('template.moncompte',compact('typepreferences','allpreferences'));
    }
    
    public function getTypePreferences()
    {
        $typepreferences = Preference::select('type')->distinct()->get();
        return $typepreferences;
    }

    public function getAllPreferencesByUser($userid)
    {
        $allpreferences = Preference::all('id','type','cle','user_id','valeur')->where('user_id', $userid);
        return $allpreferences;
    }
    
    public function addPreference(AccountNewRequest $request)
    {
//        if (! auth()->check()) {
//            return redirect('/login');
//        }
        $userid = Auth::user()->id;
        $preference = New Preference;

        $preference->user_id    = $userid;
        $preference->type       = $request->typepreference[0];
        $preference->cle        = $request->cle;
        $preference->valeur     = $request->valeur;

        $preference->save();
        return redirect('/moncompte');
        
    }

    public function delPreference($id)
    {
//        if (! auth()->check()) {
//            return redirect('/login');
//        }
//         $userid = Auth::user()->id;
//         Preference::select('id','type','cle','user_id','valeur')->where('id', $id)->where('user_id', $userid)->delete();
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
        //$role = User::select('role')->where('id',$id)->pluck('role');
        $role = User::where('id',$id)->pluck('role');
        return $role;
    }
}
