<?php

namespace App\Http\Middleware;

use Closure;

class StudentRole
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
        if (!auth()->user()->isStudent()) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
