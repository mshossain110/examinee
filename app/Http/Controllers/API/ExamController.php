<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Exam;
use Illuminate\Http\Request;
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
        $user = $request->user();

        $exams = Exam::with( 'subjects')->where('user_id', $user->id)->paginate();
        
        $resource = JsonResource::collection($exams);

        return $resource;
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

        $resource = New JsonResource($exam);

        return $resource;
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
        $resource = New JsonResource($exam);

        return $resource;
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
        return response()->json(['success' => true, 'message'=> 'Exam Deleted successfully.']);
    }



}
