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
        $questions = Question::where('user_id', auth()->user()->id)->latest()->paginate(4);
        return view("question.index", compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( $todo )
    {
        $exams = Exam::all();
        $topics = Topic::all();
        return view("question.create", compact('exams', 'topics', 'todo' ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $eid = $request->eid;
        $tid = $request->tid;
        $question = Question::create([ 
            'user_id'       => auth()->user()->id,
            'qtype'         => $request->qtype,
            'question'      => $request->question,
            'options'       => $request->options,
            'answer'        => $request->answer,
            'hint'          => $request->hint,
            'mark'          => $request->mark,
            'explanation'   => $request->explanation,
            'defficulty'    => $request->defficulty,
        ]);
        $question->exams()->attach( $eid, [ 'tid' => $tid ]);
        if ($request->todo != 0) {
            return redirect()->route('exam.show', $request->todo);
        }
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
    public function edit(Question $question, $todo)
    {
        $exams = Exam::all();
        $topics = Topic::all();

        return view("question.edit", compact('exams', 'topics','question', 'todo'));
        
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
        if ($request->todo != 0) {
            return redirect()->route('exam.show', $request->todo);
        }
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
        return $question->id;
    }
}
