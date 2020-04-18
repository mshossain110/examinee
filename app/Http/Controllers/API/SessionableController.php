<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use App\Session;
use App\Sessionable;

class SessionableController extends Controller
{
    public function lessons(Request $request, $course)
    {
        $sessions= Session::with(['lessons', 'exams'])->where('course_id', $course)->get();
        $sessions = $sessions->map(function($s){
            $exams = $s->exams;
            $lessons = $s->lessons;
            unset($s->exams);
            unset($s->lessons);

            $s->resources = $lessons->merge($exams);

            return $s;
        });

        return JsonResource::collection($sessions);

    }
}