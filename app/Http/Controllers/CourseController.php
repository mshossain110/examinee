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
    public function show(Request $request, Course $course)
    {
        $course->loadCount(['lessons', 'exams', 'sessions', 'students']);
        $course->load(['subjects', 'topics', 'teachers']);
        return view('course')->with(compact('course'));
    }

    public function subscribe(Request $request, Course $course)
    {
        $user = $request->user();

        $enrolled =  $user->enrolledCourses->firstWhere('id', $course->id);


        if($enrolled) {
            return response()->json([],200);
        }

        $user->enrolledCourses()->attach($course);

        $lessons = $course->lessons->pluck('id');

        $user->enrolledLessons()->attach($lessons);

        return response()->json([],200);
    }
}