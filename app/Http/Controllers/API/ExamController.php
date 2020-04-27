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

        $exams = Exam::with(['subjects','questions', 'topics']);

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
        $data = $request->all();
        $data['examiner'] = $user->id;

        $exam = Exam::create($data);


        $topics = $request->get('topics');

        if ($topics) {
            $exam->topics()->attach($topics);
        }

        $exam->subjects()->attach($subject_id);


        return new JsonResource($exam);
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
        $exam->fill($request->all());
        $exam->save();
        $exam->subjects()->detach();
        $exam->subjects()->attach($request->subject_id);

        $topics = $request->get('topics');

        if ($topics) {
            $exam->topics()->attach($topics);
        }

        return new JsonResource($exam);
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
        $exam->topics()->detach();
        $exam->delete();
        return response()->json(['success' => true, 'message'=> 'Exam Deleted successfully.']);
    }
}
