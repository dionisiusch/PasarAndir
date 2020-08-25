<?php

namespace App\Http\Middleware;

use Closure;

class GeneralManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'employer')
    {
        if (!Auth::guard($guard)->check()) {
            return redirect()->route('login');
        }

        if (Auth::guard($guard)->user()->role == 1) {
            return $next($request);
        }

        if (Auth::guard($guard)->user()->role == 2) {
            return redirect()->route('login');
        }

        if (Auth::guard($guard)->user()->role == 3) {
            return redirect()->route('login');
        }
    }
}
