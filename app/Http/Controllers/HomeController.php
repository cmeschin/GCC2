<?php

namespace App\Http\Controllers;

use App\Models\Preference;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AccountNewRequest;

//use App\Models\User;
//use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! auth()->check()) {
            return redirect('/login');
        }
        return view('home');
    }

    public function gohome()
    {
        if (! auth()->check()) {
            return redirect('/login');
        }
        return view('home');
    }
    
    public function account()
    {
        if (! auth()->check()) {
            return redirect('/login');
        }
        $typepreferences = $this->get_typepreferences();
        $allpreferences = $this->get_allpreferencesbyuser(Auth::user()->id);
        
        return view('template.moncompte',compact('typepreferences','allpreferences'));
    }
    
    public function get_typepreferences()
    {
        $typepreferences = Preference::select('type')->distinct()->get();
        return $typepreferences;
    }

    public function get_allpreferencesbyuser($userid)
    {
        $allpreferences = Preference::all('id','type','cle','user_id','valeur')->where('user_id', $userid);
        return $allpreferences;
    }
    
    public function addpreference(AccountNewRequest $request)
    {
        if (! auth()->check()) {
            return redirect('/login');
        }
        $userid = Auth::user()->id;
        $preference = New Preference;

        $preference->user_id    = $userid;
        $preference->type       = $request->typepreference[0];
        $preference->cle        = $request->cle;
        $preference->valeur     = $request->valeur;

        $preference->save();
        return $this->account();
        
    }

    public function delpreference($id)
    {
        if (! auth()->check()) {
            return redirect('/login');
        }
        $userid = Auth::user()->id;
        Preference::select('id','type','cle','user_id','valeur')->where('id', $id)->where('user_id', $userid)->delete();
        return $this->account();
        
    }
    
}
