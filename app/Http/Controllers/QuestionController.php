<?php

namespace App\Http\Controllers;

use App\Question;
use App\Subject;
use App\Topic;
use App\Exam;
use App\Http\Requests\QuestionRequest as Request;
use Log;
class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::get();
        return view("question.index", compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $exams = Exam::all();
        $topics = Topic::all();
        return view("question.create", compact('exams', 'topics'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $eid = $request->eid;
        $tid = $request->tid;
        $question = Question::create( $request->all());
        $question->exams()->attach( $eid, [ 'tid' => $tid ]);
        return redirect()->route("question.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        $exams = Exam::all();
        $topics = Topic::all();
        return view("question.edit", compact('exams', 'topics','question'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        // dd($request->all());
        $eid = $request->eid;
        $tid = $request->tid;
        $question->update( $request->all());
        $question->exams()->detach( $eid, [ 'tid' => $tid ]);
        $question->exams()->attach( $eid, [ 'tid' => $tid ]);
        return redirect()->route("question.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->exams()->detach();
        $question->delete();
        return redirect()->route('question.index');
    }
}
