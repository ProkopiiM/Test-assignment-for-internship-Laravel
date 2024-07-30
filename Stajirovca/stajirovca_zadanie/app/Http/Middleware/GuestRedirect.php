<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GuestRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /*если гость то при заходе на профиль редирект на авторизацию*/
        if (request()->routeIs('profile.*') && !Auth::guard('web')->check()) {
            return redirect()->route('login.index');
        }
        return $next($request);
    }
}
