<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;


class ForceToHttp
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
        if(Request::secure() &&
            !in_array('https', request()->route()->middleware())) {
            return Redirect::to(Request::fullUrl(), 302, [], false);
        }

        return $next($request);
    }
}
