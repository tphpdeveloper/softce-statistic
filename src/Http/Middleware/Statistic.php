<?php

namespace Softce\Statistic\Http\Middleware;

use Closure;
use \URL;

class Statistic
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
        $url = URL::current();

        return $next($request);
    }
}
