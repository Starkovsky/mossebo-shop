<?php

namespace App\Http\Middleware;

use Closure;

class ErrorIfNotAuthenticated
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
        if (! \Auth::guard($guard)->check()) {
            return response()->json([
                'status' => 'error',
                'message' => trans('Not authorized')
            ], 401);
        }

        return $next($request);
    }
}
