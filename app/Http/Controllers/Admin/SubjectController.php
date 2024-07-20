<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Subject;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectResource;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Subject::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('s');

        $subjects = Subject::query()->withCount(['courses', 'exams']);

        if($search) {
            $subjects = $subjects->where('title', 'like', "%$search%");
        }

        $subjects = $subjects->paginate();
        
        $resource = SubjectResource::collection($subjects);

        return Inertia::render(
            'admin/subjects/Index', 
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
        return Inertia::render('admin/subjects/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }
        $subject = Subject::create( $data );
        

        return to_route('admin.subjects.edit', $subject);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return Inertia::render('admin/subjects/Edit', [ 'subject' => new SubjectResource($subject) ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        $subject->title = $request->title;
        $subject->slug = $request->slug ?: Str::slug($request->title) ;
        $subject->description = $request->description;
        $subject->save();

        return to_route('admin.subjects.edit', $subject);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return to_route('admin.subjects.index');
    }
}
