<?php

namespace App\Http\Controllers\API;

use App\Lesson;
use App\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $courseId = $request->get('course_id');
        $lessons = Lesson::where('course_id', $courseId)->orderBy('position')->get();

        $resource = JsonResource::collection($lessons);

        return $resource;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $courseId = $request->get('course_id');
        $course = Course::find($courseId);

        $lesson = $course->lessons()->create($request->all());

        $resource = new JsonResource($lesson);

        return $resource;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,  Lesson $lesson)
    {
        $resource = new JsonResource($lesson);

        return $resource;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lesson $lesson)
    {
        $lesson->update($request->all());
        
        $resource = new JsonResource($lesson);

        return $resource;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return response()->json(['Lesson Delete successfully.']);
    }
}
