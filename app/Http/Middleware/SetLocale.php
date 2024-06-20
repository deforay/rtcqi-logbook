<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use DB;


class SetLocale
{
    public function handle($request, Closure $next)
    {
        $user = DB::table('users')->where('user_id', 1)->first();
        $locale = session('locale', $user->prefered_language);
        App::setLocale($locale);

        return $next($request);
    }
}
