<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;


//    public function login()
//    {
//        $username = $this->username();
//        if ( $username == Auth::user()->get($username) ) {
//            AuthenticatesUsers::login();
////            return redirect('/login');
//        }else{
//            RegistersUsers::register();
//        };
//    }


/**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Surcharge en cas d'echec d'authentification
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sendFailedLoginResponse($request)
    {
        $username= $request->username;
        return view('auth.register',compact('username'));
//        throw ValidationException::withMessages([
//            $this->username() => [trans('auth.failed')],
//        ]);
    }

    public function username()
    {
        return 'username';
    }
}
