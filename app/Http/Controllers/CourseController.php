<?php


namespace App\Http\Controllers;

use Auth;
use App\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __invoke(Request $request, Course $course)
    {

        return $course;
    }
}