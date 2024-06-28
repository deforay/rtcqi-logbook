<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use DB;


class SetLocale
{
    public function handle($request, Closure $next)
    {
        $config = DB::table('global_config')->where('global_name', "prefered_language")->first();
        if ($config) {
            $locale = $config->global_value;
            App::setLocale($locale);
            $training_mode = DB::table('global_config')->where('global_name', "training_mode")->first();
            session()->put('training_mode', $training_mode->global_value);
            if ($training_mode) {
                $training_message = DB::table('global_config')->where('global_name', "training_message")->first();
                session()->put('training_message', $training_message->global_value);
            }
            return $next($request);
        }
        App::setLocale("en");
        return $next($request);
    }
}
