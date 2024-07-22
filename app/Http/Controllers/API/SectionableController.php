<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Course;
use App\Models\Section;
use App\Models\Sectionable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionableController extends Controller
{
    public function lessons(Request $request, Course $course)
    {
        $hasVisibility = $this->hasVisibility($course);

        $with = ['lessons', 'exams'];
        if ($hasVisibility) {
            $with[] = 'lessons.files';
        }


        $sections= Section::with($with)->where('course_id', $course->id)->get();
        $sections = $sections->map(function($s) use($hasVisibility) {
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

        return JsonResource::collection($sections);

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