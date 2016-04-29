<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
class VeryBasicMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if($request->getUser() != 'menu' || $request->getPassword() != 'online') {
            $headers = array('WWW-Authenticate' => 'Basic');
            return Response::make('Invalid credentials.', 401, $headers);
        }else{
            return $next($request);
        }
        
    }

}
