<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class IpSsiMiddleware
{
    private static $_allowed_ips = [
        "172.19.0.1",
        "127.0.0.1",
        "172.17.0.1",
        "198.232.218.254",
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Pre-Middleware Action
        if (!in_array($request->ip(), self::$_allowed_ips)) {
            Log::debug("IP requested ->{$request->ip()}");
            Log::debug("IP requested ->" . in_array($request->ip(), self::$_allowed_ips));
            // here insted checking single ip address we can do collection of ip
            //address in constant file and check with in_array function
            abort(403, 'Access denied');
        }

        $response = $next($request);

        // Post-Middleware Action

        return $response;
    }
}
