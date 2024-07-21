<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Resources\LessonResource;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Course $course)
    {
        $courseId = $request->get('course_id');
        // $course = Course::find($courseId);
        $lessons = $course->lessons()->orderBy('position')->get();

        $resource = LessonResource::collection($lessons);

        return Inertia::render(
            'admin/courses/Lessons', 
            [
                'course' => new CourseResource($course),
                'response' => $resource,
            ]
        );

    }

        /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/courses/CreateLesson');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Course $course)
    {
        $user = $request->user();
        $courseId = $request->get('course_id');
        $topics = $request->get('topics');

        $data = $request->all();
        $data['created_by'] = $user->id;
        $data['updated_by'] = $user->id;
        $lesson = Lesson::create($data);

        if ($topics) {
            $lesson->topics()->attach($topics);
        }

        if ($request->session) {
            $lesson->sessions()->attach($request->session, [
                'course_id' => $courseId,
            ]);

            $lesson->load(['sessionable']);
        }

        if ($request->has('object')) {
            $lesson->setLessonObject();
        }
        

        return to_route('admin.lessons.edit', [$course, $lesson] );
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course, Lesson $lesson)
    {
        return Inertia::render('admin/courses/CreateLesson', [ 
            'course' => new CourseResource($course),
            'lesson' => new LessonResource($$lesson)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course, Lesson $lesson)
    {
        $courseId = $request->get('course_id');
        $topics = $request->get('topics');
        
        $lesson->update($request->all());

        if ($topics) {
            $lesson->topics()->attach($topics);
        }

        if ($request->session) {
            $lesson->sessions()->attach($request->session, [
                'course_id' => $courseId,
            ]);

            $lesson->load(['sessionable']);
        }
        
        if ($request->has('object')) {
            $lesson->setLessonObject();
        }
        
        return to_route('admin.lessons.edit', [$course, $lesson] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course, Lesson $lesson)
    {
        $lesson->delete();

        return to_route('admin.lessons.index', [$course] );
    }
}
