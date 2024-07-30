<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\CaruselProduct;
use App\Models\Category;
use App\Models\Product;
use App\Models\RecommendProduct;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /*главное окно с слайдером и рекомендованными продуктами*/
    public function index()
    {
        $list = CaruselProduct::all();
        $recommend_product = RecommendProduct::all();
        $list_product = Product::all();
        $list_recommend_product = [];
        $list_main_product = [];
        foreach ($list_product as $product) {
            foreach ($list as $product_item) {
                if ($product_item->product_id == $product->id) {
                    $list_main_product[] = $product;
                }
            }
        }
        foreach ($list_product as $product) {
            foreach ($recommend_product as $product_item) {
                if ($product_item->product_id == $product->id) {
                    $list_recommend_product[] = $product;
                }
            }
        }
        $categories = Category::all();
        return view('main', ['list_main_product' => $list_main_product, 'list_recommend_product' => $list_recommend_product, 'categories' => $categories]);
    }
    /*P.S  на стадии написания комментариев понял что можно было и сократить как бы*/
}
