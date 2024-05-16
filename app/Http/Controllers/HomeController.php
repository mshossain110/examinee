<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubjectResource;
use App\Models\Subject;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __invoke(Request $request)
    {
        $subjects = Subject::with(['courses', 'exams'])
            ->whereHas('courses')
            ->get();
        return Inertia::render('Home/Home', [
            'subjects' => SubjectResource::collection($subjects) 
        ]);
    }
}
