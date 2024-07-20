<?php

namespace App\Http\Controllers;

use App\Actions\GetInstratorCousesAction;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class InstructorController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function courses(Request $request)
    {
        if ($request->has('user'))
        {
            $user = User::find($request->user);
        }else {
            $user = $request->user();
        }
        
        if(!$user) {
            return to_route('home');
        }

        return Inertia::render('Instructor/Courses', [
            'courses' => GetInstratorCousesAction::getCourses($user),
            'canModify' => $request->user()->id == $user->id
        ]);
    }
}
