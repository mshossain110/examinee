<?php

namespace App\Http\Controllers\API;

use App\Exam;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Resources\Json\JsonResource;

class TakeExamController extends Controller
{
    public function show(Request $request, Exam $exam)
    {
        $user = $request->user();
        $time = Session::get("exam_time.$user->id");
        return new JsonResource(compact(['exam', 'time']));
    }


    public function start (Request $request, Exam $exam)
    {
        $user = $request->user();
        $time = Session::get("exam_time.$user->id");

        if (!$time) {
            $time = Session::put("exam_time.$user->id", Carbon::now());
        }

        $questions_ids = Session::get("exam_question");
        // dd(Session::has("exam_question.2910"));
        if (!$questions_ids) {
            $questions = $exam->questions->shuffle()->take($exam->number_of_questions)->map(function($q){
                Session::put("exam_question.$q->id", true);
                return collect($q->toArray())->only(['id', 'qtype', 'question', 'options', 'hint', 'mark', 'nmark'])->all();
            })->all(); //
        } else {
            $questions = $exam->questions->filter(function($q){
                return Session::has("exam_question.$q->id");
            })->map(function($q){
                return collect($q->toArray())->only(['id', 'qtype', 'question', 'options', 'hint', 'mark', 'nmark'])->all();
            })->all();
        }

        return new JsonResource(compact('exam', 'time', 'questions'));
    }

    public function answer(Request $request, Exam $exam)
    {
        $user = $request->user();
        $time = Session::get("exam_time.$user->id");

        if ($time && Carbon::parse($time)->diffInMinutes(Carbon::now()) < $exam->duration ) {

        }
    }

}