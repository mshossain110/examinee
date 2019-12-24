<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Topic;
use App\Result;
use App\Subject;
use App\Question;
use Illuminate\Http\Request;
use App\Events\ExamWasCreated;
use App\Http\Requests\ExamRequest;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $exams = Exam::with('subjects', 'questions')->where([
                ['examiner', auth()->user()->id],
                ['title', 'like', '%' . $request->search . '%']
            ])->get();
            return view("exam.ajax.index", [
                'exams' => $exams
            ]);
        }
        $exams = Exam::with('subjects', 'questions')->where('user_id', auth()->user()->id)->paginate(6);
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
        $subjects = Subject::where('user_id', auth()->user()->id)->get();
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
        // dd(auth()->user()->id);
        $sid = $request->input('sid');
        $exam = Exam::create([
            'user_id'       => auth()->user()->id,
            'title'         => $request->title,
            'description'   => $request->description
        ]);
        $eid = $exam->id;
        $exam->subjects()->attach($sid);

        // broadcast event
        // broadcast(new ExamWasCreated($exam))->toOthers();

        return redirect()->route('exam.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Exam $exam)
    {
        $max = $exam->examResults->pluck('obtain')->max();
        $avg = $exam->examResults->pluck('obtain')->avg();
        $min = $exam->examResults->pluck('obtain')->min();
        
        $result = [];
        $result[0] = $exam->examResults->where('obtain', round($min))->count();
        $result[1] = $exam->examResults->where('obtain', round($avg))->count();
        $result[2] = $exam->examResults->where('obtain', round($max))->count();

        $dataset = implode(',', $result);
        $totalMarks = $this->calculateTotalMark($exam->questions);

        $questions = $exam->questions()->latest()->paginate(2, ['*'], 'questions');
        
        // if has ajax request
        if ($request->ajax()) {
            if ($request->has('questions')) {
                return view('exam.ajax.questions', ['questions' => $questions, 'exam' => $exam]);
            }
            return back();
        }

        return view('exam.show', compact('exam', 'result', 'questions', 'totalMarks', 'dataset', 'min', 'max', 'avg'));
    }

    public function start(Exam $exam)
    {
        $exam->load('questions');
        return view('exam.exam', compact('exam'));
    }

    public function end(Request $request, Exam $exam, Result $result)
    {
        $totalMarks = $this->calculateTotalMark($exam->questions);
        $earnMarks = Result::calculateMark($request->answer);

        $result = Result::create([
            'sid'    => auth()->user()->id,
            'eid'    => $exam->id,
            'answer' => $request->answer,
            'obtain' => $earnMarks,
        ]);

        return redirect()->route('student.home')->with('msg', 'Thanks for you exam <br> You got ' .$earnMarks .' out of '.$totalMarks .' marks');
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
        $exam->subjects()->attach($request->sid);
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
        // dd($exam);
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
