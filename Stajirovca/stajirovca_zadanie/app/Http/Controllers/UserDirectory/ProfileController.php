<?php

namespace App\Http\Controllers\UserDirectory;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /*форма профиля*/
    public function index()
    {
        return view('UserDirectory.Profile.profile');
    }

    /*пользовательские данные*/
    public function user_data()
    {
        $user = Auth::guard('web')->user();
        return view('UserDirectory.Profile.user_data')->with('user', $user);
    }

    /*история заказов*/
    public function order_history()
    {
        $orders = Order::with('status')->where('user_id', Auth::id())->get();
        foreach ($orders as $order) {
            $products = json_decode($order->products,true);
            $order->products = $products;
            if (is_string($order->products))
            {
                $products = json_decode($order->products,true);
                $order->products = $products;
            }
        }
        return view('UserDirectory.Profile.order_history')->with('orders',$orders);
    }

    /*обновление персональных данных пользователя*/
    public function update(UpdateUserRequest $request)
    {
        $validated = $request->validated();
        $user = User::where('id', $request->input('id'))->first();
        $user_upadate = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
        ];
        if (!empty($validated['password'])) {
            $user_upadate['password'] = Hash::make($validated['password']);
        }
        $user->update($user_upadate);
        return redirect()->back('UserDirectory.Profile.user_data')->with(['status'=>'Данные обнавлены!']);
    }
}
