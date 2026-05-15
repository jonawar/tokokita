<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtCookieMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($token = $request->cookie('token')) {
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }

        try {
            if ($user = JWTAuth::parseToken()->authenticate()) {
                // Manually log in the user for the web guard if needed
                auth()->login($user);
            }
        } catch (\Exception $e) {
            // Token is invalid or not present
        }

        return $next($request);
    }
}
