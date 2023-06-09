<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {

        $TYPE = [
           'admin' => 1,
           'stuff' => 2,
           'user' => 3,
        ];

        $userType = intval($request->user()->user_types_id);

        foreach ($roles as $role) {
            if ($userType === $TYPE[$role]) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized access');
    }
}