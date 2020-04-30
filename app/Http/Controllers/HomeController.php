<?php

namespace App\Http\Controllers;

use App\Course;
use App\Subject;
use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __invoke(Request $request)
    {   
        $subjects = Subject::with(['courses', 'exams'])
            ->whereHas('courses')
            ->get();
        return view('home')->with(compact('subjects'));
    }
}
