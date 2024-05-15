<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class LearningController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function myCourses(Request $request)
    {   
        return view('learning.index');
    }
}
