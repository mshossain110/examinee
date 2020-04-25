<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Course;
use App\Session;
use App\Sessionable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionableController extends Controller
{
    public function lessons(Request $request, Course $course)
    {
        $hasVisibility = $this->hasVisibility($course);

        $with = ['lessons', 'exams'];
        if ($hasVisibility) {
            $with[] = 'lessons.files';
        }


        $sessions= Session::with($with)->where('course_id', $course->id)->get();
        $sessions = $sessions->map(function($s) use($hasVisibility) {
            $exams = $s->exams;
            $lessons = $s->lessons;
            if ($hasVisibility) {
                $lessons->makeVisible(['object', 'full_text']);
            }
            unset($s->exams);
            unset($s->lessons);

            $s->resources = $lessons->merge($exams);

            return $s;
        });

        return JsonResource::collection($sessions);

    }

    protected function hasVisibility (Course $course) {
        if (!Auth::check()) {
            return false;
        }

        $user = Auth::user();

        if ($course->teachers->where('id', $user->id)->isEmpty()) {
            return false;
        }

        return true;
    }
}