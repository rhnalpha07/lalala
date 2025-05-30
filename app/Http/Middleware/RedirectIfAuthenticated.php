<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
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
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Check if this is an admin guard and request is for admin section
                if ($guard === 'admin') {
                    // Only redirect admin if trying to access login/register pages
                    if ($request->is('admin/login') || $request->is('admin/register')) {
                        return redirect(RouteServiceProvider::ADMIN_HOME);
                    }
                } else {
                    // For regular users
                    return redirect(RouteServiceProvider::HOME);
                }
            }
        }

        return $next($request);
    }
} 