<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;

class AuthenticateSecret
{
    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  array $guards
     *
     * @return mixed
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if( !$request->has('secret') || $request->input('secret') != config('app.secret') )
            return \Response::json(['error' => 'unauthenticated'], 403);

        return $next($request);
    }
}
