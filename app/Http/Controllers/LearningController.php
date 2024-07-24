<?php

namespace App\Http\Controllers;

use App\Actions\CourseWithSections;
use Auth;
use Inertia\Inertia;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Actions\GetEnrolledCousesAction;
use App\Http\Resources\CourseResource;
use App\Http\Resources\ExamResource;
use App\Http\Resources\LessonResource;
use App\Models\Exam;
use App\Models\Lesson;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LearningController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function myCourses(Request $request)
    {
        $user = $request->user();

        return Inertia::render('Learning/Courses', [
            'courses' => GetEnrolledCousesAction::getCourses($user),
            'canModify' => $request->user()->id == $user->id
        ]);
    }

    public function startCourse(Course $course)
    {
        $last = DB::table('course_students')->where('course_id', $course->id)->first()->last_lesson;

        if (!$last) {
            $course = CourseWithSections::getCourses($course);
            $firstResource = $course->sections?->first()?->resources?->first();

            if ($firstResource) {
                if (is_a($firstResource, Lesson::class)) {
                    $type = 'lesson';
                    $slug = $firstResource->slug;
                } else {
                    $type = 'exam';
                    $slug = $firstResource->slug;
                }
            }

            return to_route('start.resource', [$course->slug, $type, $slug]);
        }

    }

    public function singleResource(Course $course, $type, $slug)
    {
        if ($type == 'lesson') {
            $resource = new LessonResource(Lesson::where('slug', $slug)->first()) ;
        } else {
            $resource = new ExamResource(Exam::where('slug', $slug)->first()) ;
        }
        
        return Inertia::render('Learning/SingleResource', [
            'course' => CourseWithSections::getCourses($course),
            'resource' => $resource
        ]);
    }
}
