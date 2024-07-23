<?php


namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Models\Course;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CourseController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Request $request, Course $course)
    {
        $course->loadCount(['lessons', 'exams', 'sections', 'students']);
        $course->load(['subjects', 'topics', 'teachers']);

        return Inertia::render('Course/Course', [
            'course' => new CourseResource($course)
        ]);
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