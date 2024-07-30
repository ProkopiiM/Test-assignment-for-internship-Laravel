<?php

namespace App\Http\Controllers\AdminDirectory\ManagmentComponents;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Card;
use App\Models\CaruselProduct;
use App\Models\Category;
use App\Models\Manufacture;
use App\Models\Product;
use App\Models\RecommendProduct;
use App\Models\Review;
use App\Models\StatusReview;

class ManagmentComponentsController extends Controller
{
    /*форма компонентов*/
    public function index()
    {
        return view('AdminDirectory.ComponentManagment.component-managment');
    }

    /*форма для категорий*/
    public function category()
    {
        return view('AdminDirectory.ComponentManagment.CategoryManagment.category-managment',['brands'=>Brand::all()]);
    }

    /*форма для отзывов*/
    public function review()
    {
        return view('AdminDirectory.ComponentManagment.ReviewManagment.review-managment',['reviews'=>Review::all(), 'status'=>StatusReview::all()]);
    }

    /*форма для карточек информации*/
    public function information()
    {
        return view('AdminDirectory.ComponentManagment.InformationManagment.information-managment',['cards'=> Card::all()]);
    }

    /*форма для производителей*/
    public function manufacturer()
    {
        return view('AdminDirectory.ComponentManagment.ManufacturerManagment.manufacturer-managment.blade.php',['manufacturers'=> Manufacture::all()]);
    }

    /*форма для главной страницы*/
    public function main_layout()
    {
        $list = CaruselProduct::all();
        $recommend_product = RecommendProduct::all();
        $list_product = Product::all();
        $list_recommend_product = [];
        $list_slider_product = [];
        foreach ($list_product as $product) {
            foreach ($list as $product_item) {
                if ($product_item->product_id == $product->id) {
                    $list_slider_product[] = $product;
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
        $products = Product::all();
        return view('AdminDirectory.ComponentManagment.MainManagment.main-layout-managment', ['products'=>$products,'list_slider_products' => $list_slider_product, 'list_recommend_products' => $list_recommend_product]);
    }
}
