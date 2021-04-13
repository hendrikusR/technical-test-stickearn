<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {   
        //get user type from session login, if 1 = admin , 0 = user
        if (Auth::check()) {
            if(Auth::user()->user_type != 1) {
                return redirect('/play');
            }
        }
        return $next($request); 
        
    }
}
