<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Question;
use App\Exam;
use App\Http\Requests\QuestionRequest as Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $examId = $request->get('exam_id');
        $questions = Exam::find($examId)->questions;
        
        $resource = JsonResource::collection($questions);

        return $resource;
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $eid = $request->get('exam_id');
        $exam = Exam::findOrFail($eid);

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
       
        $resource = New JsonResource($question);

        return $resource;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $resource = New JsonResource($question);

        return $resource;
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
        $question->update( $request->all() );
        
        $resource = New JsonResource($question);

        return $resource;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return response()->json(['success' => true, 'message'=> 'Question has deleted']);
    }
}
