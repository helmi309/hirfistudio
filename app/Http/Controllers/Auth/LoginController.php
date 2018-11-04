<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\UserLoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    public function postLogin(UserLoginRequest $request)
    {
        // return $request->all();
        if (Auth::attempt($request->only('email', 'password'), true)) {


            session()->put('username', Auth::user()->username);
            session()->put('email', Auth::user()->email);
            session()->put('level', Auth::user()->level);
            session()->put('user_id', Auth::user()->id);
                return redirect()->route('backoffice');
        } else {
            session()->flash('auth_message', 'Kombinasi email dan password salah!');
                        return redirect()->route('signin');
        }

    }

    public function getLogout()
    {
        Auth::logout();

        return redirect()->route('signin');
    }
}