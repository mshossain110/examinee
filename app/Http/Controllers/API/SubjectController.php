<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use App\Subject;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('s');

        $subjects = Subject::query();

        if($search) {
            $subjects = $subjects->where('title', 'like', "%$search%");
        }

        $subjects = $subjects->get();
        
        $resource = JsonResource::collection($subjects);

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
        $subject = Subject::create( $request->all() );
        
        $resource = New JsonResource($subject);

        return $resource;
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Topic  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        $resource = New JsonResource($subject);

        return $resource;
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
        $subject->description = $request->description;
        $subject->save();
        $resource = New JsonResource($subject);

        return $resource;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {

        $subject->question()->detach();
        $subject->delete();

        return response()->json(['success' => true, 'message' => 'Subject has deleted success fully.']);
    }
}
