<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /*проверка если у пользователя доступ к админ панели*/
        if ((request()->routeIs('admin-panel.*')
                || request()->routeIs('managment-product.*')
                || request()->routeIs('managment-order.*')
                || request()->routeIs('managment-user.*')
                || request()->routeIs('managment-component.*')) && (!Auth::guard('admin')->check())) {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.index')->with('status', 'У Вас нет доступа.');
        }
        return $next($request);
    }
}
