<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
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
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $field = filter_var($request->get($this->username()), FILTER_VALIDATE_EMAIL)
            ? $this->username()
            : 'name';

        return [
            $field => $request->{$this->username()},
            'password'=>$request->password,
        ];
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

        if ($request->ajax()) {
            return response()->json(['success' => true, 'redirectTo' => $this->redirectPath()]);
        }

        return redirect($this->redirectPath());
    }

}
