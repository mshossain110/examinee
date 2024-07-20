<?php

namespace App\Http\Controllers\Admin;


use Inertia\Inertia;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Requests\TopicRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\TopicResource;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Topic::class);
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('s');

        $topics = Topic::query();

        $topics = $topics->withCount(['courses', 'exams']);

        if($search) {
            $topics = $topics->where('title', 'like', "%$search%");
        }

        $topics = $topics->paginate();
        
        $resource = TopicResource::collection($topics);
        return Inertia::render(
            'admin/topics/Index', 
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
        return Inertia::render('admin/topics/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TopicRequest $request)
    {
        $topic = Topic::create( $request->all() );

        return to_route('admin.topics.edit', $topic);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Topic $topic)
    {
        return Inertia::render('admin/topics/Edit', [ 'topic' => new TopicResource($topic) ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(TopicRequest $request, Topic $topic)
    {
        $topic->title = $request->title;
        $topic->description = $request->description;
        $topic->save();

        return to_route('admin.topics.edit', $topic);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topic $topic)
    {
        $topic->delete();

        return to_route('admin.topics.index');
    }
}
