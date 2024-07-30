<?php

namespace App\Http\Controllers\UserDirectory;

use App\Http\Controllers\Controller;
use App\Models\Backet;
use App\Models\Order;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\ReceivingType;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /*форма для заказов*/
    public function index(Request $request)
    {
        if (auth()->guard('web')->check()) {
            $backet = Backet::where('user_id', auth()->id())->first();
            $user = auth()->user();
            $backet_list = json_decode($backet->products, true);
        } else {
            $backet_list = session()->get('backet', []);
            $backet_list = $backet_list['items'];
            $user = null;
        }
        $payment = PaymentType::all();
        $receiving = ReceivingType::all();
        $status = Status::all();
        return view('UserDirectory.Order.create_order', ['backet_list' => $backet_list, 'payments' => $payment, 'receivings' => $receiving, 'statuses' => $status,'user'=>$user]);
    }

    /*создание заказа*/
    public function store(Request $request)
    {
        $payment = $request->input('payment');
        $receiving = $request->input('receiving');
        $address = $request->input('address');
        $email = $request->input('email');
        $name = $request->input('name');
        $total = $request->input('total');
        $phone = $request->input('phone');
        /*если пользователь авторизован*/
        if (auth()->guard('web')->check())
        {
            $backet = Backet::where('user_id',auth()->id())->first();
            $backet_list = json_decode($backet->products,true);
            $backet_list = json_encode($backet->products,true);
            $user = auth()->id();
        }
        /*если пользователь не авторизрован*/
        else {
            $user = User::where('email',$email)->first();
            $user = $user->id;
            $backet_list = session()->get('backet', []);
            $backet_list = $backet_list['items'];
            $backet_list = json_encode($backet_list,true);
        }
        if ($payment == null || $receiving == null || $email == null || $name == null || $phone == null || ($address == null && $receiving == 1)) {
            $error = 'Не все поля заполнены';
            return redirect()->back()->with('error', $error);
        }
        /*создание заказа*/
        $order = Order::create([
                'user_id'=>$user,
                'products'=>$backet_list,
                'total'=>$total,
                'status_id'=>1,
                'payment_type_id'=>$payment,
                'receiving_type_id'=>$receiving,
                'phone'=>$phone,
                'email'=>$email,
                'FIO'=>$name,
                'address'=>$address,
                'comment'=>null
        ]);
        if (auth()->guard('web')->check())
        {
            Backet::where('user_id',auth()->guard('web')->id())->first()->delete();
        }
        else
        {
            session()->forget('backet');
        }
        return redirect()->route('order.success')->with('status', 'Заказ успешно оформлен!');
    }
}
