<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Cookie;

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
    protected $redirectTo = '/';

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
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        if (session('link')) {
            $myPath = session('link');
            $loginPath = url('/login');
            $previous = url()->previous();

            if ($previous = $loginPath) {
                session(['link' => $myPath]);
            } else {
                session(['link' => $previous]);
            }
        } else {
            session(['link' => url()->previous()]);
        }

        return view('auth.login');
    }

    protected function redirectTo()
    {
        if (session('link')) {
            return session('link');
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/';
    }

    /**
     * The user has been authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed                    $user
     *
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {

        
        $token = $user->createToken('Tasqers Personal Access Client')->accessToken;
        Cookie::queue(Cookie::make('access_token', $token, 24 * 60));
        if ($request->ajax()) {
            return response()->json(['success' => true, 'redirectTo' => $this->redirectPath(), 'token' => $token]);
        }

        return redirect($this->redirectPath())->with('token', $token);
    }

}
