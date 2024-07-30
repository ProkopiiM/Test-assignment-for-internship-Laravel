<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /*если пользователь авторизован то попасть на тсраницу с входом нельзя*/
        if ((request()->route('login')
                || request()->routeIs('password.*')
                || request()->routeIs('registration.*')) && Auth::guard('web')->check()) {
            return redirect()->back();
        }
        if (Auth::guard('admin')->check() && request()->routeIs('admin.*')) {
            return redirect()->back();
        }
        return $next($request);
    }
}
