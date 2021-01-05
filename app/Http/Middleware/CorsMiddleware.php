<?php

namespace App\Http\Middleware;

class CorsMiddleware
{
    public function handle($request, \Closure $next)
    {
        $response = null;
        /* Preflight handle */
        //if ($request->isMethod('OPTIONS')) {
        //    $response = new Response();
        //} else {
            $response = $next($request);
       // }

        $response->header('Access-Control-Allow-Methods', 'OPTIONS, HEAD, GET, POST, PUT, DELETE');
        $response->header('Access-Control-Allow-Headers', $request->header('Access-Control-Request-Headers'));
        $response->header('Access-Control-Allow-Origin', '*');

        return $response;
    }
}