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
    public function index(Request $request)
    {
        $user = $request->user();
        $courses = Course::query();

        if(! $user->isAdmin() ) {
            $courses = $courses->whereHas('teachers', function($q) use($user){
                $q->where('id', $user->id);
            });
        }

        $courses = $courses->paginate();

        return Inertia::render(
            'admin/courses/Index', 
            [
                'response' => CourseResource::collection($courses),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/courses/CreateCourse');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $data = $request->only(['title', 'subtitle', 'slug', 'description', 'price', 'discount', 'thumbnail', 'start_date', 'status', 'certified']);
        $data['created_by'] = $user->id;
        $data['updated_by'] = $user->id;
        $course = $user->instructCourses()->create($data);


        return to_route('admin.courses.edit', $course);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        return Inertia::render('admin/courses/CreateCourse', [ 'course' => new CourseResource($course) ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, course $course)
    {
        $user = $request->user();
        $data = $request->all();
        $data['updated_by'] = $user->id;

        $course->update($data);

        return to_route('admin.courses.edit', $course);
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
