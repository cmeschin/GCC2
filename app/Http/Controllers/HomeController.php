<?php

namespace App\Http\Controllers;

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
    
}
