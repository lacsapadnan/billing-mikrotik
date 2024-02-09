<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use App\Support\Facades\Log;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? ['customer'] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                Log::put(Auth::user()->username.' logged in', Auth::user());

                return redirect(RouteServiceProvider::HOME[$guard]);
            }
        }

        return $next($request);
    }
}
