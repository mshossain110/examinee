<?php

namespace App\Http\Controllers\API;

use App\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $courses = $user->instructs();

        $collection = JsonResource::collection($courses);

        return $collection->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $data = $request->all();
        $data['created_by'] = $user->id;
        $data['updated_by'] = $user->id;
        $course = $user->instructs()->create($data);

        $resource = New JsonResource($course);

        return $resource;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        $resource = New JsonResource($course);

        return $resource;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $user = $request->user();
        $data = $request->all();
        $data['updated_by'] = $user->id;
        $course = $course->update($data);

        $resource = New JsonResource($course);

        return $resource;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->lessons()->delete();
        $resource->delete();

        return response(['Course delete successfully']);
    }
}
