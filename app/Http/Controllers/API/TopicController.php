<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use App\Topic;
use App\Http\Requests\TopicRequest;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('s');

        $topics = Topic::query();

        if($search) {
            $topics = $topics->where('title', 'like', "%$search%");
        }

        $topics = $topics->get();
        
        $resource = JsonResource::collection($topics);

        return $resource;
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TopicRequest $request)
    {
        $topic = Topic::create( $request->all() );
        
        $resource = New JsonResource($topic);

        return $resource;
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function show(Topic $topic)
    {
        $resource = New JsonResource($topic);

        return $resource;
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
        $resource = New JsonResource($topic);

        return $resource;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topic $topic)
    {
        // dd($topic);
        $topic->question()->detach();
        $topic->delete();

        return response()->json(['success' => true, 'message' => 'Topic has deleted success fully.']);
    }
}
