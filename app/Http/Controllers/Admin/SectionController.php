<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use Inertia\Inertia;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Resources\SectionResource;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Course $course, Request $request)
    {
        $sections = $course->sections()->with(['lessons', 'exams'])->get();

        return Inertia::render(
            'admin/courses/Sections', 
            [
                'course' =>  new CourseResource($course),
                'sections' => SectionResource::collection($sections),
            ]
        );
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Course $course, Request $request)
    {
        $section = $course->sections()->create($request->all());
        
        return to_route('admin.sections.index', $course);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Section  $section
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Course $course, Section $section, Request $request)
    {
        $section->title = $request->title;
        $section->description = $request->description;
        $section->save();

        return to_route('admin.sections.index', $course);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $Section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course, Section $section)
    {
        $section->delete();

        return to_route('admin.sections.index', $course);
    }

    public function attachExam (Request $request, Section $section) { 
        $exam = Exam::find($request->exam_id);
        $section->exams()->attach($exam, ['course_id' => $section->course_id]);

        return to_route('admin.sections.index', $section->course_id);
    }

    public function attachLession (Request $request, Section $section) {
        $lesson = Lesson::find($request->lesson_id);
        $section->lessons()->attach($lesson, ['course_id' => $section->course_id]);

        return to_route('admin.sections.index', $section->course_id);
    }
}
