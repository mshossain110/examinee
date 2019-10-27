<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
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
    public function index(Request $request)
    {
        $examId = $request->get('exam_id');
        $questions = Exam::find($examId)->questions()->paginate();
        
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
        // dd($request->all());
        $eid = $request->eid;
        $tid = $request->tid;
        $question->update( $request->all());
        $question->exams()->detach( $eid, [ 'tid' => $tid ]);
        $question->exams()->attach( $eid, [ 'tid' => $tid ]);
        
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
        $question->exams()->detach();
        $question->delete();
        return response()->json(['success' => true, 'message'=> 'Question has deleted']);
    }
}
