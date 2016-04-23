<?php

namespace App\Http\Middleware;

use Closure;
use App\Stat;
use App\Http\Controllers\Controller;
use App\Http\Middleware\Response;
use Cache;
use Carbon\Carbon;
class StatsMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $stats = Stat::find(1);
        $stats->views++;
        $stats->save();

        $req = md5($request->fullUrl());
        if(Cache::store('database')->has($req)) {
            $controller = new Controller;
            return response(Cache::store('database')->get($req),200,
                                ['Content-Type'=>'application/json',
                                    'from-cache'=>true]);
        }
        return $next($request);
    }
    
    public function terminate($request,$response) {
        $req = md5($request->fullUrl());
        if(!Cache::store('database')->has($req)) {
            $expiresAt = Carbon::now()->addMinutes(10);
            //var_dump($response->getContent());
            Cache::store('database')->put($req, $response->getContent(), $expiresAt);
        }
    }
}
