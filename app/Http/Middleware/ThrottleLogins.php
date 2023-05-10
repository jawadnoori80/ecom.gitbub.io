<?php

namespace App\Http\Controllers\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;

class ThrottleLogins
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $attempts, $minutes)
    {
        $key = $request->ip(); // or $request->user()->id
        $maxAttempts = $attempts;
        $decayMinutes = $minutes;

        $limiter = app(RateLimiter::class)->for($key, $maxAttempts, $decayMinutes);

        if ($limiter->tooManyAttempts()) {
            abort(429, 'Too many login attempts. Please try again later.');
        }

        return $next($request);
    }
}
