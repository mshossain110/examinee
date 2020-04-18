<?php

namespace App\Http\Controllers\API;

use App\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

class MyCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $courses = Course::withCount('lessons')->whereHas('students', function($query) use($user){
            $query->where('user_id', $user->id);
        })->get();

        $collection = JsonResource::collection($courses);

        return $collection->response();
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Course $course)
    {

        $course->load([
            'teachers'
        ]);
        
        $resource = New JsonResource($course);

        return $resource;
    }

}
