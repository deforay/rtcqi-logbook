<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use DB;


class SetLocale
{
    public function handle($request, Closure $next)
    {
        $user_id = session('userId') ?? 1;
        // dd($user_id);
        $user = DB::table('users')->where('user_id', $user_id)->first();
        $locale = session('locale', $user->prefered_language);
        App::setLocale($locale);

        return $next($request);
    }
}
