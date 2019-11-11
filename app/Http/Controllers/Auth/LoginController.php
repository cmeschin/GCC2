<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
////            RegistersUsers::register();
//            $username= $request->username;
//            return view('auth.register',compact('username'));
//
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
    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sendFailedLoginResponse(Request $request)
    {
        $username= $request->username;
        if (User::where('username', $username)->value('id')) { // si le username est connu on indique le mot de passe est incorrect
            throw ValidationException::withMessages([
                $this->username() => [trans('auth.failed')],
            ]);
        } else { // sinon on affiche la page d'enregistrement
            return view('auth.register',compact('username'));
        };
    }


    //    public function sendFailedLoginResponse($request)
//    {
////        $username= $request->username;
////        return view('auth.register',compact('username'));
//        throw ValidationException::withMessages([
//            $this->username() => [trans('auth.failed')],
//        ]);
//    }

    public function username()
    {
        return 'username';
    }
}
