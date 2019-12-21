<?php

namespace App\Http\Controllers\API;

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
        $user = $request->user();
        $subject_id = $request->input('subject_id');
        $exam = Exam::create([
            'examiner'       => $user->id,
            'title'         => $request->title,
            'description'   => $request->description
        ]);

        $exam->subjects()->attach($subject_id);

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
        $exam->subjects()->attach( $request->subject_id );
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
        $exam->questions()->delete();
        $exam->delete();
        return response()->json(['success' => true, 'message'=> 'Exam Deleted successfully.']);
    }
}
