<?php

namespace App\Http\Controllers\UserDirectory;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Category;
use App\Models\Manufacture;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /*поиск сортировка и фильтрация товаров*/
    public function index(Request $request)
    {
        $query = $request->input('search');
        $sort = $request->input('sort');
        $paginate = $request->input('paginate');
        $category = $request->input('category');
        $min_price = $request->input('min-price');
        $max_price = $request->input('max-price');
        $rating = $request->input('rating');
        $manufacturer = $request->input('manufacturer');
        $is_set = $request->input('is_set');

        if (isset($sort) && !empty($sort) && $sort != 'default')
        {
            list($a,$b) = explode('_',$sort);
        }
        else
        {
            $a = 'id';
            $b = 'asc';
        }
        $products = Product::query()->with('reviews')->withAvg('reviews', 'star')
            ->withCount('reviews')
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%$query%");
            })
            ->when($category, function ($q) use ($category) {
                $q->where('category_id', $category);
            })
            ->when($min_price, function ($q) use ($min_price) {
                $q->whereRaw('price - (price * discount / 100) >= ?', [$min_price]);
            })
            ->when($max_price, function ($q) use ($max_price) {
                $q->whereRaw('price - (price * discount / 100) <= ?', [$max_price]);
            })
            ->when($rating, function ($q) use ($rating) {
                $q->having('reviews_avg_star', $rating);
            })
            ->when($manufacturer, function ($q) use ($manufacturer) {
                if ($manufacturer != 'all')
                {
                    $q->where('manufacture_id',$manufacturer);
                }
            })
            ->when($is_set, function ($q) use ($is_set) {
                if ($is_set == 'yes')
                {
                    $q->where('quantity', '>' , 0);
                }
                elseif ($is_set == 'no')
                {
                    $q->where('quantity', '<=' , 0);
                }
            })
            ->when($sort, function ($q) use ($b, $a) {
                if ($a == 'rating') {
                    $q->orderBy('reviews_avg_star', $b);
                }
                elseif ($a == 'popularity')
                {
                    $q->orderBy('reviews_count', $b);
                }
                else{
                    $q->orderBy($a, $b);
                }
            })
            ->paginate($paginate ?: 15);

        $cards = Card::where('status', 1)->get();
        $categories = Category::all();
        return view('UserDirectory.Search.search',['manufacturers'=>Manufacture::all(),'products'=> $products, 'categories'=>$categories,'cards'=>$cards]);
    }
}
