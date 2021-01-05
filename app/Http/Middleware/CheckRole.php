<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class CheckRole
 * @package App\Http\Middleware
 *
 * https://gist.github.com/amochohan/8cb599ee5dc0af5f4246
 */

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role = null)
    {
        // Get the required roles from the route
        $roles = $this->getRequiredRoleForRoute($request->route());
        // Check if a role is required for the route, and
        // if so, ensure that the user has that role.
        if ($request->user()->hasRole($roles) || !$roles) {
            return $next($request);
        }

        return response([
            'error' => [
                'code' => 'INSUFFICIENT_ROLE',
                'description' => 'You are not authorized to access this resource.'
            ]
        ], 401);
    }

    private function getRequiredRoleForRoute($route)
    {
        $actions = $route[1]['roles'];
        return $actions ?: null;
    }
}


