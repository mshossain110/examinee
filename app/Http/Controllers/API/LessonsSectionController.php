<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use App\LessonsSection;

class LessonsSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('s');

        $topics = LessonsSection::query();

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
    public function store(Request $request)
    {
        $topic = LessonsSection::create( $request->all() );
        
        $resource = New JsonResource($topic);

        return $resource;
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LessonsSection  $lessonsSection
     * @return \Illuminate\Http\Response
     */
    public function show(LessonsSection $lessonsSection)
    {
        $resource = New JsonResource($lessonsSection);

        return $resource;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LessonsSection  $lessonsSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LessonsSection $lessonsSection)
    {
        $lessonsSection->title = $request->title;
        $lessonsSection->description = $request->description;
        $lessonsSection->save();
        $resource = New JsonResource($lessonsSection);

        return $resource;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LessonsSection  $lessonsSection
     * @return \Illuminate\Http\Response
     */
    public function destroy(LessonsSection $lessonsSection)
    {
        $lessonsSection->delete();

        return response()->json(['success' => true, 'message' => 'Lessen section has deleted success fully.']);
    }
}
