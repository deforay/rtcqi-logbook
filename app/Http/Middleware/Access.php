<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;
class Access
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
        if(session('login')==true)
        {
            return $next($request);
        }
        else
        {
            return Redirect::to('login')->with('status', 'Please Login');
        }
    }
}
