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
        $courseId = $request->get('course_id');

        $exams = Exam::with(['subjects','questions']);

        if ($courseId) {
            $exams = $exams->whereHas('courses', function ($q) use ($courseId) {
                $q->where('course_id', $courseId);
            });
        } else {
            $exams = $exams->where('examiner', $user->id);
        }
        
        $exams = $exams->get();
        
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

        $resource = new JsonResource($exam);

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
        $exam->subjects()->attach($request->subject_id);
        $resource = new JsonResource($exam);

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
        $exam->subjects()->detach();
        $exam->questions()->delete();
        $exam->delete();
        return response()->json(['success' => true, 'message'=> 'Exam Deleted successfully.']);
    }
}
