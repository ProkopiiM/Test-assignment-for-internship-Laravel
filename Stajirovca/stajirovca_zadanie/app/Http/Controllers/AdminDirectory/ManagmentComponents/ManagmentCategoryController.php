<?php

namespace App\Http\Controllers\AdminDirectory\ManagmentComponents;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ManagmentCategoryController extends Controller
{
    /*для формы новой категории*/
    public function category_index()
    {
        return view('AdminDirectory.ComponentManagment.CategoryManagment.category-view',['category'=>null]);
    }


    /*для редактирования категории*/
    public function category_create(Request $request)
    {
        $category = Category::where('id',$request->input('id'))->first();
        return view('AdminDirectory.ComponentManagment.CategoryManagment.category-view',['category'=>$category]);
    }

    /*обновление категории*/
    public function category_update(Request $request)
    {
        $category = Category::where('id',$request->input('id'))->first();
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->save();
        return redirect()->route('admin-panel.category.index');
    }

    /*удаление категории*/
    public function category_destroy(Request $request)
    {
        foreach (Product::all() as $product) {
            if ($product->category_id == $request->input('id')) {
                $product->category_id = null;
                $product->save();
            }
        }
        Category::destroy($request->input('id'));
        return redirect()->back();
    }

    /*для создания категории*/
    public function category_store(Request $request)
    {
        $category = new Category();
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->save();
        return redirect()->route('admin-panel.category.index');
    }


    /*для формы нового бренда*/
    public function brand_index()
    {
        return view('AdminDirectory.ComponentManagment.CategoryManagment.brand-view',['brand'=>null]);
    }

    /*для формы редактирования бренда*/
    public function brand_create(Request $request)
    {
        return view('AdminDirectory.ComponentManagment.CategoryManagment.brand-view',['brand'=>Brand::where('id',$request->input('id'))->first()]);
    }

    /*редактирование бренда*/
    public function brand_update(Request $request)
    {
        Brand::where('id',$request->input('id'))->update(['name' => $request->input('name')]);
        return redirect()->route('admin-panel.category.index');
    }

    /*удаление бренда*/
    public function brand_destroy(Request $request)
    {
        foreach (Product::all() as $product) {
            if ($product->brand_id == $request->input('id')) {
                $product->brand_id = null;
            }
        }
        Brand::destroy($request->input('id'));
        return redirect()->route('admin-panel.category.index');
    }

    /*создание нового бренда*/
    public function brand_store(Request $request)
    {
        $brand = new Brand();
        $brand->name = $request->input('name');
        $brand->save();
        return redirect()->route('admin-panel.category.index');
    }
}
