<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\ExamRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExamResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Exam::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $courseId = $request->get('course_id');

        $exams = Exam::with(['subjects', 'questions', 'topics']);

        if ($courseId) {
            $exams = $exams->whereHas('courses', function ($q) use ($courseId) {
                $q->where('course_id', $courseId);
            });
        }

        $exams = $exams->paginate();

        $resource = ExamResource::collection($exams);

        return Inertia::render(
            'admin/exams/Index',
            [
                'response' => $resource
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/exams/Create');
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


        return to_route('admin.exams.edit', $exam);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam)
    {
        return Inertia::render('admin/exams/Edit', ['exam' => new ExamResource($exam)]);
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

        return to_route('admin.exams.edit', $exam);
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

        return to_route('admin.exams.index');
    }
}
