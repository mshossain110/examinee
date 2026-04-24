<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Http\Resources\SubjectResource;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __invoke(Request $request)
    {
        $subjects = Subject::withCount(['courses', 'exams'])
            ->with(['courses', 'exams'])
            ->whereHas('courses')
            ->get();

        $featuredCourses = Course::with(['teachers', 'subjects'])
            ->withCount(['lessons', 'students'])
            ->latest()
            ->limit(8)
            ->get();

        return Inertia::render('Home/Home', [
            'subjects'        => SubjectResource::collection($subjects),
            'featuredCourses' => CourseResource::collection($featuredCourses),
        ]);
    }
}
