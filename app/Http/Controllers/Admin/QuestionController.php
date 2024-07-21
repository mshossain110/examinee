<?php
namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use Inertia\Inertia;
use App\Models\Question;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Requests\QuestionRequest as Request;
use App\Http\Resources\ExamResource;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Exam $exam)
    {
        $questions = $exam->questions;
        
        $resource = QuestionResource::collection($questions);

        return Inertia::render(
            'admin/exams/Questions',
            [
                'exam' => new ExamResource($exam),
                'questions' => $resource
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Exam $exam)
    {
        return Inertia::render('admin/exams/CreateQuestion', [
            'exam' => new ExamResource($exam)
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Exam $exam)
    {
        $user = $request->user();

        $question = $exam->questions()->create([
            'created_by'    => $user->id,
            'qtype'         => $request->qtype,
            'question'      => $request->question,
            'options'       => $request->options,
            'answers'       => $request->answers,
            'hint'          => $request->hint,
            'mark'          => $request->mark,
            'nmark'         => $request->nmark,
            'explanation'   => $request->explanation
        ]);
       
        return to_route('admin.questions.edit', [$exam, $question]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam, Question $question)
    {
        return Inertia::render('admin/exams/CreateQuestion', [
            'exam' => new ExamResource($exam),
            'question' => new QuestionResource($question)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam, Question $question)
    {
        $question->update( $request->all() );
        
        $resource = New JsonResource($question);

        return to_route('admin.questions.edit', [$exam, $question]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam, Question $question)
    {
        $question->delete();
        return to_route('admin.questions.index', [$exam]);
    }
}
