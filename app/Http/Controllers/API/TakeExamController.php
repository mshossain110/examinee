<?php

namespace App\Http\Controllers\API;

use App\Exam;
use App\User;
use App\Result;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Session;

class TakeExamController extends Controller
{
    public function show(Request $request, Exam $exam)
    {
        $user = $request->user();
        $questions= collect();
        $time = Session::get("exam.$exam->id");
        $exam->load('topics', 'subjects');
        $result = $exam->results()->where('examinee', $user->id)->orderBy('created_at', "DESC")->first();

        if ($result && !empty($exam->meta['show_answer']) &&  $exam->meta['show_answer']) {
            $q = $exam->questions;
            
            
            collect($result->answers)->map(function($qi) use($q, $questions){
                $questions->push($q->firstWhere('id', $qi['id']));
            });

            // $questions = $questions->map(function($q) use($questionFields){
            //     return collect($q->toArray())->only($questionFields)->all();
            // })->values()->all();

            if (!(!empty($exam->meta['show_answer']) &&  $exam->meta['show_answer'])) {
                $questions = $questions->map(function($ques) {
                    unset($ques->answers);
                    return $ques;
                });
            }
        }

        
        
        return response()->json(compact(['exam', 'time', 'result',  'questions']));
    }


    public function start (Request $request, Exam $exam)
    {
        $user = $request->user();

        if (!$this->userCanTakeExam($user, $exam)) {
           return; 
        }
    
        
        $time = Session::get("exam.$exam->id");

        if (!$time) {
            $time = Session::put("exam.$exam->id", Carbon::now());
            $time = Session::get("exam.$exam->id");
        }
        $answers = Session::get("exam_question");
        $answers = collect($answers);

        $questionFields = ['id', 'qtype', 'question', 'options' , 'mark', 'nmark'];

        if (!empty($exam->meta['show_hint']) && $exam->meta['show_hint']) {
            $questionFields[] = 'hint';
        }

        if ($answers->isEmpty()) {
            $questions = $exam->questions->shuffle()->take($exam->number_of_questions)->map(function($q) use($answers, $questionFields){
                $answers->push(['id'=> $q->id]);
                return collect($q->toArray())->only($questionFields)->all();
            })->values()->all(); //

            Session::put("exam_question", $answers);
        } else {
            $q = $exam->questions;
            $questions= collect();

            $answers->map(function($qi) use($q, $questions){
                $questions->push($q->firstWhere('id', $qi['id']));
            });

            $questions = $questions->map(function($q) use($questionFields){
                return collect($q->toArray())->only($questionFields)->all();
            })->values()->all();
        }

        return response()->json(compact('exam', 'time', 'questions', 'answers'));
    }

    public function answer(Request $request, Exam $exam)
    {        
        $user = $request->user();
        $time = Session::get("exam.$exam->id");

        $answers = Session::get("exam_question");
        $answers = collect($answers);

        if ($time && Carbon::parse($time)->diffInMinutes(Carbon::now()) < $exam->duration ) {
            if(sizeof($request->keys()) === 1) {
                $key = $request->keys()[0];
                $ans = $request->get($key, []);
                if (!empty($ans)) {
                    $answers = $answers->map(function($q) use($ans, $key) {
                        if ($q['id'] === $key) {
                            $q['answer'] = $ans;
                        }
                        return $q;
                    });
                    Session::put("exam_question", $answers);
                }
                
            }
        }
        $answers = Session::get("exam_question");

        return compact('answers', 'time');
    }

    public function complete(Request $request, Exam $exam)
    {

        $time = Session::get("exam.$exam->id");
        $answers = Session::get("exam_question");
        $answers = collect($answers);

        $obtainMark = $this->obtain_mark($exam);
        $timeTaken = Carbon::parse($time)->diffInMinutes(Carbon::now());

        $user = $request->user();
        $result = new Result;
        
        $result->examinee = $user->id;
        $result->exam_id = $exam->id;
        $result->answers = $answers;
        $result->time_taken = $timeTaken;
        $result->obtain_mark = $obtainMark;
        $result->is_pass = $exam->pass_mark < $obtainMark;

        if ($result->save()) {
            Session::forget("exam_question");
            Session::forget("exam");
        }

        return response()->json(compact('result'));
    }

    private function obtain_mark(Exam $exam)
    {
        $number = 0;
        $answers = Session::get("exam_question");
        $answers = collect($answers);

        $questions = $exam->questions;

        $answers->each(function($ans) use($questions, &$number) {
            if(!empty($ans['answer'])) {

                $ques = $questions->firstWhere('id', $ans['id']);
                $intersect = array_intersect($ques->answers, $ans['answer'] );

                if (sizeof($intersect) === sizeof($ques->answers)) {
                    // answer is correct
                    $number += floatval($ques->mark);
                } else {
                    $number -= floatval($ques->nmark);
                }

            }
            
        });

        return $number;
        
    }

    private function userCanTakeExam(User $user, Exam $exam)
    {
        $time = Session::get("exam");
        if ($time && empty($time[$exam->id])){
            throw  new Exception(__("Exam id :key running", ["key" => array_keys($time)[0]]));
        }
        
        $result = $exam->results()->where('examinee', $user->id)->orderBy('created_at', "DESC")->first();
        if ($result) {
            $differ = ((intval($exam->meta['retake'])?: 0 )- Carbon::parse($result->created_at)->diffInDays(Carbon::now()) );
            if ( $differ > 0){
                throw  new Exception(__("You can retry after :day days", ["day" => $differ]));
            }
        }
        

        return true;
    }
}