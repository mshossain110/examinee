<?php

namespace App\Http\Controllers\Admin;


use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Models\Course;

class CoursesController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Course::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render(
            'admin/courses/Index', 
            [
                'response' => CourseResource::collection(Course::paginate()),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/courses/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $data = $request->only([
            'name',
            
        ]);

        $course = course::create($data);


        return Inertia::render('admin/courses/Edit', [ 'course' => new CourseResource($course) ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return Inertia::render('admin/courses/Create', [
            'course' => new CourseResource($course)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        return Inertia::render('admin/courses/Edit', [ 'course' => new CourseResource($course) ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, course $course)
    {
        $validated = $request->validate([
            'name' => 'required|string'
        ]);

        $data = $request->all();

        $course = $course->update($data);

        return Inertia::render('admin/courses/Edit', [ 'course' => new CourseResource($course) ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(course $course)
    {
        $course->delete();

        return to_route('admin.courses.index');
    }
}
