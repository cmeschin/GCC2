<?php

namespace App\Http\Controllers;

use App\Models\Preference;
use Illuminate\Support\Facades\Auth;

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
    
}
