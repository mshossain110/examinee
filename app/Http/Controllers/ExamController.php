<?php

namespace App\Http\Controllers;

use App\Exam;
use Illuminate\Http\Request;
use App\Http\Requests\ExamRequest;
use App\Subject;
use App\Question;
use App\Topic;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exams = Exam::with( 'subjects', 'questions' )->paginate(15);
        return view("exam.index", [
            'exams' => $exams
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = Subject::all();
        return view("exam.create", [
            'subjects' => $subjects
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExamRequest $request)
    {
        $sid = $request->input('sid');
        $exam = Exam::create( $request->all() );
        $exam->subjects()->attach($sid);
        return redirect()->route('exam.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        return view('exam.show', compact('exam'));
    }

    public function start( Exam $exam )
    {
        $exam->load('questions');
        return view('exam.exam', compact('exam'));
    }

    public function end( Request $request, Exam $exam )
    {
        dd($request->all());
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam)
    {
        $subjects = Subject::all();
        return view("exam.edit", [
            'subjects' => $subjects,
            'exam'     => $exam
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(ExamRequest $request, Exam $exam)
    {
        $exam->title = $request->title;
        $exam->description = $request->description;
        $exam->save();
        $exam->subject()->detach();
        $exam->subject()->attach( $request->sid );
        return redirect()->route('exam.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        $exam->subject()->detach();
        $exam->delete();
        return redirect()->route('exam.index');
    }
}
