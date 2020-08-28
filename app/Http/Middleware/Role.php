<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::guard('employer')->check()) {
            return redirect('login');
        }
            
        $employer = Auth::guard('employer')->user();
        
        foreach($roles as $role) {
            if($employer->hasRole($role)) {
                return $next($request);
            }
        }

        return redirect('login');
    }
}
