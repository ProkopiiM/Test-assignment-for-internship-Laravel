<?php

namespace App\Http\Controllers\AuthDirectory;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthUserController extends Controller
{
    /*форма для авторизации в клиентской части*/
    public function index()
    {
        return view('UserDirectory.Login.login');
    }

    /*авторизация в клиентской части*/
    public function store(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!empty($user))
        {
            if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
                /*онулирование корзины*/
                $backet = session()->get('backet',[]);
                if (!empty($backet)) {
                    foreach ($backet['items'] as $item) {
                        $count = Product::where('id', $item['id'])->first()->quantity;
                        Product::where('id', $item['id'])->update(['quantity' => $count + $item['quantity']]);
                    }
                    session()->remove('backet');
                }
                return redirect()->route('main.index');
            } else {
                return redirect()->back()->with('error', 'Неверный логин или пароль');
            }
        }
    }

    /*выход из клиентской части*/
    public function logout()
    {
        Auth::guard('web')->logout();
        session()->remove('backet');
        return redirect()->route('main.index');
    }
}
