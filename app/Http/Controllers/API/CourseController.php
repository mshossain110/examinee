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
        $courses = $user->instructCourses;

        return JsonResource::collection($courses);
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
        $data = $request->only(['title', 'slug', 'description', 'price', 'thumbnail', 'start_date', 'status', 'certified']);
        $data['created_by'] = $user->id;
        $data['updated_by'] = $user->id;
        $course = $user->instructCourses()->create($data);

        
        $course->files()->sync($request->input('files', []));
        

        return new JsonResource($course);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        $course->load(['files']);
        $resource = new JsonResource($course);

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

        $course->update($data);

        $course->files()->sync($request->input('files', []));
        
        $course->load(['files']);
        $resource = new JsonResource($course);

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
        $course->files()->sync([]);
        $course->delete();

        return response(['Course delete successfully']);
    }


    /**
     * get course students 
     */

     public function students(Request $request, Course $course)
     {
         $students = $course->students;

         return JsonResource::collection($students);
     }
}
