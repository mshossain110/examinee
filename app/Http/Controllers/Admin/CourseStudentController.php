<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseStudentsResource;

class CourseStudentController extends Controller
{
    public function __invoke(Course $course)
    {
        $students = $course->students;

        return Inertia::render('admin/courses/CourseStudent', [
            'course' => new CourseResource($course),
            'students' => CourseStudentsResource::collection($students) 
        ]);
    }
}