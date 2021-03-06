<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Providers\RouteServiceProvider;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function show_login()
    {
        return view('auth.login');
    }

    protected function login(LoginRequest $request)
    {
        $remember_me = $request->has('remember');
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials, $remember_me)) {
            return redirect()->route('home');
        } else {
            return redirect()->route('login')->withErrors('Wrong username/password combination.');
        }
    }

    protected function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
