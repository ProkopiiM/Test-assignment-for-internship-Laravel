<?php

namespace App\Http\Controllers\UserDirectory;

use App\Http\Requests\RegistrationRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegistrationController extends Controller
{
    /*форма для регистрации пользователя*/
    public function index()
    {
        return view('UserDirectory.Registration.registration');
    }

    /*регистрация и онулирование корзины*/
    public function store(RegistrationRequest $request)
    {
        $validation = $request->validated();
        $backet = session()->get('backet',[]);
        if (!empty($backet)) {
            foreach ($backet['items'] as $item) {
                $count = Product::where('id', $item['id'])->first()->quantity;
                Product::where('id', $item['id'])->update(['quantity' => $count + $item['quantity']]);
            }
            session()->remove('backet');
        }
        User::create($validation);
        return redirect()->route('main.index')->with('registration','Вы зарегистрированы!');
    }
}
