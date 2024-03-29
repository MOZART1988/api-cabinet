<?php

namespace App\Http\Middleware;

use Closure;

class apiMiddleware
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

        $response = $next($request);

        $response->headers->set('Content-Type', 'application/json;charset=utf8');

        return $response;

    }
}
