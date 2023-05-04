<?php

namespace App\Http\Middleware;

use Closure;

class CheckRoleAuthorization
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
        
        $routeInfo = $request->route()->getAction();
        
        //dd($routeInfo);
        list($resource,$view) = explode("@",$routeInfo['controller']);
        
           
        if ((isset($role[$resource][$view]) && (trim($role[$resource][$view]) == "deny")) || (!isset($role[$resource][$view]))){
           return redirect('/unauthorized');
        }
        return $next($request);
    }
}
