<?php

namespace App\Http\Middleware;

use Closure;
use App\Stat;
class StatsMiddleware
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
       
        $stats = Stat::find(1);
        $stats->views++;
        $stats->save();
        return $next($request);
    }
}
