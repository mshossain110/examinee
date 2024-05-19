<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class InstructorController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function courses(Request $request)
    {
        return Inertia::render('Instructor/Courses');
    }
}
