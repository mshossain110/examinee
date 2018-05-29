<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Topic;
use App\Result;
use App\Subject;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Requests\ExamRequest;

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
        $eid = $exam->id;
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
        
        $totalMarks = $this->calculateTotalMark($exam->questions);
        return view('exam.show', compact('exam', 'totalMarks'));
    }

    public function start( Exam $exam )
    {
        $exam->load('questions');
        return view('exam.exam', compact('exam'));
    }

    public function end( Request $request, Exam $exam, Result $result )
    {
        Result::create([
            'sid' => auth()->user()->id,
            'eid' => $exam->id,
            'answer' => $request->answer,
        ]);
        return redirect()->route('student.home')->with('msg', 'Thanks for you exam');
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
        // dd($request->all());

        $exam->title = $request->title;
        $exam->description = $request->description;
        $exam->save();
        $exam->subjects()->detach();
        $exam->subjects()->attach( $request->sid );
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
        $exam->subjects()->detach();
        $exam->delete();
        return redirect()->route('exam.index');
    }

    public function calculateTotalMark($marks)
    {
        $count = 0;
        foreach ($marks as $mark) {
            $count = $count + $mark->mark;
        }
        return $count;
    }

}
