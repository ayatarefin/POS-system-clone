<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckSessionExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
{
    if (Auth::check() && time() - session('last_activity_time') > config('session.lifetime') * 60) {
        Auth::logout();
        return redirect('/login')->with('error', 'Your session has expired. Please log in again.');
    }

    // Update last activity time
    session(['last_activity_time' => time()]);

    return $next($request);
}
}
