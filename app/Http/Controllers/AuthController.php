<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function registerView($value='')
    {
        return view('auth.register');
    }

    
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required | email | unique:users,email',
            'password' => 'required | min:4 | confirmed',
            'role' => 'in:'. User::TEACHER .','.User::STUDENT
        ];
        $this->validate($request, $rules);

        $user = User::create([

            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id'  => $request->role
        ]);
        
        if (!$user->save()) {
            return back();
        }
        return redirect('login');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
        {
            // dd($request->all());
            $rules = [
                'email' => 'required | email | exists:users,email',
                'password' => 'required'
            ];
            $this->validate($request, $rules);

            $auth = [
                'email' => $request->email,
                'password' => $request->password
            ]; 

            $remember = $request->remember;
            // dd($remember);
            $sessionValue = $request->session()->get('key');
            $sessionTime  = $request->session()->get('time');

            if ($sessionValue >= 1) {
                if ($sessionTime == null) {
                    $request->session()->put('time', Carbon::now());    //put the current time to session
                }
                $timeDiff = Carbon::parse($sessionTime)->diffInSeconds(); //calculate time
                if ($timeDiff >= 59) {
                    if (auth()->attempt($auth, $remember)) {
                        if (auth()->user()->isTeacher()) {
                            return redirect()->route('home');
                        }
                        elseif (auth()->user()->isStudent()) {
                            $request->session()->flush();
                            dd("Under Contraction");
                            // return redirect()->route('home');
                        }
                        else{
                            $request->session()->flush();
                            return redirect()->route('login')->with('msg', 'you have to verify account');
                        }
                        
                    }
                    else{
                        $request->session()->flush();
                        return back()->with('msg', 'you have to verify account');
                    }
                    
                }else{
                    $waitTime = 59 - $timeDiff;
                    return back()->with('msg', 'you have to wait ' . $waitTime . ' sec')
                                ->with('title', 'Login Error');
                }
                

            }
            $sessionValue = $sessionValue + 1;
            $request->session()->put('key', $sessionValue);
            if (auth()->attempt($auth, $remember)) {
                if (auth()->user()->isTeacher()) {
                    return redirect()->route('home');
                }
                elseif (auth()->user()->isStudent()) {
                    $request->session()->flush();
                    dd("Under Contraction");
                    // return redirect()->route('home');
                }
                else{
                    return redirect()->route('login');
                }
                
            }
            else{
                return back()->with('msg', 'you have to verify account')
                    ->with('title', 'Login Error');
            }


        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        \Auth::logout();
        return redirect()->route('login');
    }
}
