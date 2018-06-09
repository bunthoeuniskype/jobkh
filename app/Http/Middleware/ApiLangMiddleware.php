<?php

namespace App\Http\Middleware;

use Closure;
use Config;

class ApiLangMiddleware
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
        if($request->lang){
            Config::set('app.locale',$request->lang);
        }
        return $next($request);
    }
}
