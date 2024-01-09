<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        $guard = in_array('auth:admin', $request->route()->middleware()) ? 'admin' : 'customer';

        return $request->expectsJson() ? null : RouteServiceProvider::LOGIN[$guard];
    }
}
