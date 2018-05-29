<?php

namespace App\Http\Middleware;
use App\User;
use Closure;

class TeacherRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->user()->isTeacher()) {
            return redirect()->route('student.home');
        }
        return $next($request);
    }
}
