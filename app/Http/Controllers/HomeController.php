<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

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
        $account = new Account;
        $role = $account->isAdmin(Auth::user()->id)->get(0);
        return view('home', compact('role'));
    }

    /**
     * Show MyAccount form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function account()
    {
        $account = new Account;
        $typepreferences = $account->getTypePreferences();
        $allpreferences = $account->getAllPreferencesByUser(Auth::user()->id);
        
        return view('template.moncompte',compact('typepreferences','allpreferences'));
    }
}