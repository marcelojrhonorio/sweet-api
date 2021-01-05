<?php

namespace App\Http\Middleware;

use App\ThirdPartyClient;
use Closure;
use Exception;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;

class ThirdPartyClientMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!$request->hasHeader('Authorization')) {
            return response()->json('Authorization Hearder not found', 401);
        }

        $token = $request->bearerToken();

        if ($request->header('Authorization') == null || $token == null) {
            // Unauthorized response if token not there
            return response()->json([
                'error' => 'Token not provided.',
            ], 401);
        }

        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch (ExpiredException $e) {
            return response()->json([
                'error' => 'Provided token is expired.',
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error while decoding token.',
            ], 400);
        }

        $t = ThirdPartyClient::find($credentials->sub);

        // Now let's put the user in the request class so that you can grab it from there
        $request->auth = $t;

        return $next($request);
    }
}
