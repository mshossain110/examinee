<?php

namespace App\Http\Controllers;

use Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Actions\GetEnrolledCousesAction;

class LearningController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function myCourses(Request $request)
    {
        $user = $request->user();

        return Inertia::render('Learning/Courses', [
            'courses' => GetEnrolledCousesAction::getCourses($user),
            'canModify' => $request->user()->id == $user->id
        ]);
    }
}
