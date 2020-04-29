<?php

namespace App\Http\Controllers\API;

use App\Exam;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class TakeExamController extends Controller
{
    public function show(Request $request, Exam $exam)
    {
        $user = $request->user();
        $time = Session::get("exam_time.$user->id");
        return response()->json(compact(['exam', 'time']));
    }


    public function start (Request $request, Exam $exam)
    {

        $user = $request->user();
        $time = Session::get("exam_time.$user->id");

        if (!$time) {
            $time = Session::put("exam_time.$user->id", Carbon::now());
        }
        
        $answers = Session::get("exam_question");
        
        if (!$answers) {
            $questions = $exam->questions->shuffle()->take($exam->number_of_questions)->map(function($q){
                Session::put("exam_question.$q->id", true);
                return collect($q->toArray())->only(['id', 'qtype', 'question', 'options', 'hint', 'mark', 'nmark'])->all();
            })->values()->all(); //
        } else {
            $questions = $exam->questions->filter(function($q){
                return Session::has("exam_question.$q->id");
            })->map(function($q){
                return collect($q->toArray())->only(['id', 'qtype', 'question', 'options', 'hint', 'mark', 'nmark'])->all();
            })->values()->all();
        }

        return response()->json(compact('exam', 'time', 'questions', 'answers'));
    }

    public function answer(Request $request, Exam $exam)
    {
        
        $user = $request->user();
        $time = Session::get("exam_time.$user->id");

        if ($time && Carbon::parse($time)->diffInMinutes(Carbon::now()) < $exam->duration ) {
            if(sizeof($request->keys()) === 1) {
                $key = $request->keys()[0];
                Session::put("exam_question.$key", $request->input($key));
            }
        }
        $answers = Session::get("exam_question");

        return compact('answers', 'time');
    }

    public function complete(Request $request)
    {
        Session::forget("exam_question");
        Session::forget("exam_time");
    }

}