<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Lesson;
use App\Course;
use Illuminate\Http\Request;

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
        // $course = Course::find($courseId);
        $lessons = Lesson::with('topics')->where('course_id', $courseId)->orderBy('position')->get();

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
        $lesson->load(['courses', 'files']);
        $lesson->makeVisible('object', 'full_text');
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
