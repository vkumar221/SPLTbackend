<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if(collect($request->route()->middleware())->contains('api')){
            return route('unauthenticated-api');
        }
        else if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
