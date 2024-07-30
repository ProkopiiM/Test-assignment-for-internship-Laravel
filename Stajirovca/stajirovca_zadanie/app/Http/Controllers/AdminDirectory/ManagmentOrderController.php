<?php

namespace App\Http\Controllers\AdminDirectory;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentType;
use App\Models\ReceivingType;
use App\Models\Status;
use Illuminate\Http\Request;

class ManagmentOrderController extends Controller
{
    /*сортировка  и фильтрация заказов*/
    public function index(Request $request)
    {
        $sort = $request->input('sort');
        $paginate = $request->input('paginate',15);
        $min_total = $request->input('min-total');
        $max_total = $request->input('max-total');
        $status = $request->input('status');
        $payment_type = $request->input('payment_type');
        $receivind_type = $request->input('receivind-type');
        if (isset($sort) && !empty($sort) && $sort != 'default' && $sort != 'status_asc' && $sort != 'status_desc')
        {
            list($a,$b) = explode('_',$sort);
        }
        elseif ($sort == 'status_asc' || $sort == 'status_desc')
        {
            list($a,$b) = explode('_',$sort);
            $a = 'status_id';
        }
        else
        {
            $a = 'id';
            $b = 'asc';
        }

        $orders = Order::query()->with('status')
            ->when($status, function ($q) use ($status) {
                if ($status != 'all')
                {
                    $q->where('status_id', $status);
                }
            })->when($payment_type, function ($q) use ($payment_type) {
                if ($payment_type != 'all')
                {
                    $q->where('payment_type_id', $payment_type);
                }
            })->when($receivind_type, function ($q) use ($receivind_type) {
                if ($receivind_type != 'all')
                {
                    $q->where('receiving_type_id', $receivind_type);
                }
            })->when($min_total, function ($q) use ($min_total) {
                $q->where('total', '>=', $min_total);
            })->when($max_total, function ($q) use ($max_total) {
                $q->where('total', '<=', $max_total);
            })->when($sort, function ($q) use ($a,$b) {
                $q->orderBy($a, $b);
            })->paginate($paginate);
        $payment_types = PaymentType::all();
        $receivind_types = ReceivingType::all();
        $statuses = Status::all();

        foreach ($orders as $order )
        {
            $products = json_decode($order->products,true);
            $order->products = $products;
            if (is_string($order->products))
            {
                $order->products = json_decode($order->products,true);
            }
        }
        return view('AdminDirectory.OrdersManagment.order-managment')->with(['statuses'=>$statuses, 'payment_types'=>$payment_types, 'receiving_types'=>$receivind_types, 'orders'=> $orders]);
    }

    /*обновление статуса заказа*/
    public function update(Request $request)
    {
        Order::where('id', $request->input('id'))->update(['status_id' => $request->input('status_id'), 'comment' => $request->input('comment')]);
        return redirect()->back();
    }
}
