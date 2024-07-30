<?php

namespace App\Http\Controllers\AdminDirectory;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Card;
use App\Models\Category;
use App\Models\Manufacture;
use App\Models\PhotoProduct;
use App\Models\Product;
use App\Models\ProductBonds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManagmentProductController extends Controller
{
    /*поиск, сортировк аи фильтрация товаров*/
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
        $products = Product::query()->with('category')->with('reviews')->withAvg('reviews', 'star')
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
        return view('AdminDirectory.ProductsManagment.product-managment',['manufacturers'=>Manufacture::all(),'products'=> $products, 'categories'=>$categories,'cards'=>$cards]);
    }

    /*вывод существующего товара / форма для добавления нового*/
    public function product_view(Request $request)
    {
        $paginate = $request->input('paginate', 15);
        if (!empty($request->input('id')))
        {
            $product = Product::with(['images', 'attributes', 'reviews.user','bond','manufacture','category','brand',
                'reviews' => function ($query) {
                    $query->where('status_id', 1);
                }
            ])->withAvg(['reviews' => function ($query) {
                $query->where('status_id', 1);
            }], 'star')->findOrFail($request->id);
            $reviews = $product->reviews()->with('user')->paginate($paginate);
            $bonds = $product->bond()->with('product')->paginate(1000);
            $manufactures = Manufacture::all();
            $categories = Category::all();
            $brands = Brand::all();
            $attribute = Attribute::all();
            return view('AdminDirectory.ProductsManagment.product-view', ['attributes'=>$attribute,'categories'=>$categories,'brands'=>$brands,'product' => $product, 'reviews' => $reviews, 'paginate' => $paginate,'bonds_products' => $bonds, 'manufactures' => $manufactures]);
        }
        else
        {
            $manufactures = Manufacture::all();
            $categories = Category::all();
            $brands = Brand::all();
            $attribute = Attribute::all();
            return view('AdminDirectory.ProductsManagment.product-view', ['attributes'=>$attribute,'categories'=>$categories,'brands'=>$brands,'product' => null, 'reviews' => null, 'paginate' => $paginate,'bonds_products' => null, 'manufactures' => $manufactures]);
        }
    }

    /*создание нового товара*/
    public function create(Request $request)
    {
        $name = $request->input('name');
        $quantity = $request->input('quantity');
        $price = $request->input('price');
        $discount = $request->input('discount');
        $category = $request->input('category_id');
        $brand = $request->input('brand_id');
        $manufacture = $request->input('manufacture_id');
        $description = $request->input('description');
        if ($request->hasFile('main_image')) {
            $mainImage = $request->file('main_image')->store('images', 'public');
        }
        $mainImage = basename($mainImage);
        $sku = $this->generateSku(12);
        Product::create([
            'main_image' => $mainImage,
            'name' => $name,
            'quantity' => $quantity,
            'price' => $price,
            'discount' => $discount,
            'category_id' => $category,
            'brand_id' => $brand,
            'manufacture_id' => $manufacture,
            'description' => $description,
            'sku' => $sku,
        ]);
        return redirect('/admin-panel/products');
    }

    /*редактирование товара*/
    public function product_edit(UpdateProductRequest $request)
    {
        $validate = $request->validated();
        $name = $request->input('name');
        $quantity = $request->input('quantity');
        $price = $request->input('price');
        $discount = $request->input('discount');
        $category = $request->input('category_id');
        $brand = $request->input('brand_id');
        $manufacture = $request->input('manufacture_id');
        $description = $request->input('description');
        $product = Product::find($request->input('id'));
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $image) {
                $path = $image->store('images', 'public');
                PhotoProduct::create([
                    'product_id' => $product->id,
                    'photo_path' => basename($path),
                ]);
            }
        }
        $product->update([
            'name' => $name,
            'quantity' => $quantity,
            'price' => $price,
            'discount' => $discount,
            'category_id' => $category,
            'brand_id' => $brand,
            'manufacture_id' => $manufacture,
            'description' => $description,
        ]);
        return redirect('/admin-panel/products');
    }

    /*доабвление сопутствующего товара*/
    public function bond_add(Request $request)
    {
        $product_bond = new ProductBonds();
        $product_bond->product_id = $request->get('product_id');
        $product_bond->bond_id = $request->get('bond_id');
        $product_bond->save();
        return redirect()->back();
    }

    /*удаление сопутствующих товаров*/
    public function bond_delete(Request $request)
    {
        $bond = ProductBonds::where('product_id', $request->input('product_id'))->where('bond_id',$request->input('bond_id'))->delete();
        return redirect()->back();
    }

    /*добавление атрибутов товару*/
    public function product_tech_attribute_add(Request $request)
    {
        AttributeValue::create([
            'attribute_id' => $request->input('attribute_id'),
            'value' => $request->input('value'),
            'product_id' => $request->input('product_id'),
        ]);
        return redirect()->back();
    }

    /*удаление атрибутов у товара*/
    public function product_tech_attribute_delete(Request $request)
    {
        AttributeValue::where('product_id', $request->input('product_id'))->where('attribute_id', $request->input('attribute_id'))->delete();
        return redirect()->back();
    }

    /*удаление фотографии у товара*/
    public function product_image_delete(Request $request)
    {
        $image_id = $request->input('image_del_id');
        $product_id = $request->input('product_id');
        $image = PhotoProduct::where('id', $image_id)->where('product_id',$product_id)->first();
        if ($image) {
            Storage::disk('public')->delete($image->photo_path);
            $image->delete();
        }
        return redirect()->back();
    }




    /*создание артикуля*/
    function generateSku($length = 12) {
        // Определяем возможные символы для SKU
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        // Генерируем случайную строк из указанных символов
        $sku = '';
        for ($i = 0; $i < $length; $i++) {
            $sku .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $sku;
    }
}
