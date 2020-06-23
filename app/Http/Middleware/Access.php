<?php

namespace App\Http\Middleware;

use Closure;

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
        $role = session('role');
        if(($role == null)){
            return redirect('/login');
        }
        // print_r($role);
        $routeInfo = $request->route()->getAction();
        // print_r($routeInfo);
        list($resource,$view) = explode("@",$routeInfo['controller']);
        //    print_r($role[$resource]);die;
        if ((isset($role[$resource][$view]) && (trim($role[$resource][$view]) == "deny")) || (!isset($role[$resource][$view]))){
           return redirect('/unauthorized');
        }
        return $next($request);
    }
}
