<?php

namespace App\Http\Middleware;

use Closure;

class Collector
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
        if (!Auth::check()) {
            return redirect()->route('employerlogin');
        }

        if (Auth::user()->role == 3) {
            return $next($request);
        }
    }
}
