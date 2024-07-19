<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectResource;

class DashboardController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __invoke(Request $request)
    {
        return Inertia::render('admin/Dashboard');
    }
}
