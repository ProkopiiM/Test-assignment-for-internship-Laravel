<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\PhotoProduct;
use App\Models\Product;
use App\Models\ProductBonds;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /*Вывод товара*/
    public function index(Request $request)
    {
        $product = Product::with(['images', 'attributes', 'reviews.user','bond','manufacture',
            'reviews' => function ($query) {
                $query->where('status_id', 1);
                }
            ])->withAvg(['reviews' => function ($query) {
            $query->where('status_id', 1);
        }], 'star')->findOrFail($request->id);
        $paginate = $request->input('paginate', 15);
        $reviews = $product->reviews()->with('user')->paginate($paginate);
        $bonds = $product->bond()->with('product')->paginate(1000);
        return view('product', ['product' => $product, 'reviews' => $reviews, 'paginate' => $paginate,'bonds_products' => $bonds]);
    }

    /*создание отзыва*/
    public function store_review(Request $request)
    {
        $review = Review::create([
            'user_id'=>$request->input('user_id'),
            'product_id'=>$request->input('product_id'),
            'star'=>$request->input('rating-review'),
            'review	'=>$request->input('review-textarea'),
            'status_id'=>2
        ]);
        return redirect()->back()->with('review', 'Отзыв создан');
    }
}
