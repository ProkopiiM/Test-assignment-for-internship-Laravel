<?php

namespace App\Http\Middleware;

use App\Models\Card;
use App\Models\Category;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShareData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /*передача данных об категориях и информационных карточках на все view*/
        $categories = Category::all();
        $cards = Card::where('status',1)->get();

        view()->share('categories', $categories);
        view()->share('cards', $cards);

        return $next($request);
    }
}
