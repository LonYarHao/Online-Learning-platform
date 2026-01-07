<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticatedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::check()) {

        $routeName = optional($request->route())->getName();

        if (in_array($routeName, ['login', 'register'])) {

            $role = Auth::user()->role;

            if ($role === 'admin' || $role === 'superadmin') {
                return to_route('admin#dashboard');
            }

            if ($role === 'teacher') {
                return to_route('teacher#dashboard');
            }

            return to_route('student#dashboard');
        }
    }

    return $next($request);

    }
}
