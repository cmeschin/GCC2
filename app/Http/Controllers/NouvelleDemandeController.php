<?php

namespace App\Http\Controllers;

use App\Models\User;
//use Illuminate\Http\Request;

class NouvelleDemandeController extends Controller
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
        return view('nouvelledemande');
    }
    
    /**
     * Get user logged.
     */
    public function getUser()
    
    {
        
        $user = User::findOfFail();
        
        return view('nouvelledemande', compact('user'));
        
    }
}
