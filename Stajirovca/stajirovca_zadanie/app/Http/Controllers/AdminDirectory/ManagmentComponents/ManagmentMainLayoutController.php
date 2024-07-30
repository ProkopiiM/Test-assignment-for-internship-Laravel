<?php

namespace App\Http\Controllers\AdminDirectory\ManagmentComponents;

use App\Http\Controllers\Controller;
use App\Models\CaruselProduct;
use App\Models\RecommendProduct;
use Illuminate\Http\Request;

class ManagmentMainLayoutController extends Controller
{
    /*для добавления товара в слайдер*/
    public function slider_store(Request $request)
    {
        $caruselProduct = new CaruselProduct();
        $caruselProduct->product_id = $request->input('product_id');
        $caruselProduct->save();
        return redirect()->back();
    }

    /*для удаления товара из слайдера*/
    public function slider_destroy(Request $request)
    {
        CaruselProduct::destroy($request->input('product_id'));
        return redirect()->back();
    }

    /*для добавлени товара к рекомендованным*/
    public function recommend_store(Request $request)
    {
        $recommendProduct = new RecommendProduct();
        $recommendProduct->product_id = $request->input('product_id');
        $recommendProduct->save();
        return redirect()->back();
    }

    /*для удаления товара из рекомендованных*/
    public function recommend_destroy(Request $request)
    {
        RecommendProduct::destroy($request->input('product_id'));
        return redirect()->back();
    }
}
