<?php

namespace App\Http\Controllers\UserDirectory;

use App\Http\Controllers\Controller;
use App\Models\Backet;
use App\Models\Card;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BacketController extends Controller
{
    /*вывод корзины (уже посмотрел что называется cart)*/
    public function index()
    {
        if (Auth::guard('web')->check()) {
            $backet_list = Backet::firstOrCreate(['user_id' => auth()->guard('web')->id()]);
            if (empty($backet_list)) {
                $backet_list = null;
            }
            $backet_list = json_decode($backet_list->products, true);
            return view('UserDirectory.Backet.backet', ['backet_list'=> $backet_list]);
        }
        else
        {
            $backet_list = session()->get('backet',[]);
            $items = $backet_list['items'] ?? [];
            $backet_list['items'] = $items;
            return view('UserDirectory.Backet.backet', ['backet_list'=> $backet_list['items']]);
        }

    }

    /*добавление в корзину если пользователь как гость и как авторизованный*/
    public function store(Request $request)
    {
        $product_id = $request->input('product_id');
        $product = Product::find($product_id);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }
        if (auth()->guard('web')->check()) {
            $backet = Backet::firstOrCreate(['user_id' => auth()->id()]);
            $items = json_decode($backet->products, true) ?? [];
        }
        else
        {
            $backet = session()->get('backet',[]);
            $items = $backet['items'] ?? [];
        }
        /*дополнительные проверки если товар в количестве 0*/
        if (isset($items[$product_id])) {
            if (Product::where('id', $product_id)->first()->quantity != 0) {
                $items[$product_id]['quantity'] += 1;
                $count = Product::where('id', $product_id)->first()->quantity;
                Product::where('id', $product_id)->update(['quantity' => $count-1]);
            }
        } else {
            if (Product::where('id', $product_id)->first()->quantity != 0) {
                $items[$product_id] = [
                    "id" => $product_id,
                    "name" => $product->name,
                    "description" => $product->description,
                    "quantity" => 1,
                    "price" => $product->price,
                    "discount" => $product->discount,
                    "image" => $product->main_image
                ];
                $count = Product::where('id', $product_id)->first()->quantity;
                Product::where('id', $product_id)->update(['quantity' => $count-1]);
            }
        }

        if (auth()->guard('web')->check()) {
            $backet->products = $items;
            $backet->save();
        } else {
            $backet['items'] = $items;
            session()->put('backet', $backet);
        }
        session()->put('backet', $backet);
        return redirect()->back()->with('Успешно', 'Товар добавлен в корзину.');
    }

    /*очистка корзины если пользователь авторизован и если не авторизован*/
    public function clear(Request $request)
    {
        if (auth()->guard('web')->check()) {
            $backet = Backet::where('user_id', auth()->id())->first();
            $backet_list = json_decode($backet->products, true);
            foreach ($backet_list as $item) {
                $count = Product::where('id', $item['id'])->first()->quantity;
                Product::where('id', $item['id'])->update(['quantity' => $count + $item['quantity']]);
            }
            $backet->delete();
        }
        else
        {
            $backet = session()->get('backet',[]);
            foreach ($backet['items'] as $item) {
                $count = Product::where('id', $item['id'])->first()->quantity;
                Product::where('id', $item['id'])->update(['quantity' => $count + $item['quantity']]);
            }
            session()->remove('backet');
        }
        return redirect()->route('backet.index')->with('sucsess','Корзина очищена.');
    }

    /*управление товарами корзины*/
    public function edit(Request $request)
    {
        $user = Auth::guard('web')->user();
        $productId = $request->input('product_id');
        $action = $request->input('action');
        /*если пользователь авторизован*/
        if ($user) {
            $backet_user = Backet::where('user_id', $user->id)->first();
            $backet = json_decode($backet_user->products, true);
            if ($backet) {
                if ($action == 'plus' ) {
                    if (Product::where('id',$productId)->first()->quantity != 0) {
                        $backet[$productId]['quantity'] += 1;
                        $count = Product::where('id', $productId)->first()->quantity;
                        Product::where('id', $productId)->update(['quantity' => $count-1]);
                    }
                } elseif ($action == 'minus' && $backet[$productId]['quantity'] > 1) {
                    $backet[$productId]['quantity'] -= 1;
                    $count = Product::where('id', $productId)->first()->quantity;
                    Product::where('id', $productId)->update(['quantity' => $count+1]);
                }
                elseif ($action == 'del') {
                    $count = Product::where('id', $productId)->first()->quantity;
                    Product::where('id', $productId)->update(['quantity' => $count + $backet[$productId]['quantity']]);
                    unset($backet[$productId]);
                }
                $backet_user->products = $backet;
                $backet_user->save();
            }
        } else {
            /*если пользователь не авторизован*/
            $backet = session()->get('backet', []);
            if (isset($backet['items'][$productId])) {
                if ($action == 'plus') {
                    if (Product::where('id',$productId)->first()->quantity != 0) {
                        $backet['items'][$productId]['quantity'] += 1;
                        $count = Product::where('id', $productId)->first()->quantity;
                        Product::where('id', $productId)->update(['quantity' => $count-1]);
                    }
                } if ($action == 'minus' && $backet['items'][$productId]['quantity'] > 1) {
                    $backet['items'][$productId]['quantity'] -= 1;
                    $count = Product::where('id', $productId)->first()->quantity;
                    Product::where('id', $productId)->update(['quantity' => $count+1]);
                }
                } if ($action == 'del') {
                    $count = Product::where('id', $productId)->first()->quantity;
                    Product::where('id', $productId)->update(['quantity' => $count+$backet['items'][$productId]['quantity']]);
                    unset($backet['items'][$productId]);
                }
                session()->put('backet', $backet);
            }
        return redirect()->back();
    }
}
