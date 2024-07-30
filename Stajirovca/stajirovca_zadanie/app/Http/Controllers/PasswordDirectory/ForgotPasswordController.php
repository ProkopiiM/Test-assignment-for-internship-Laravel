<?php

namespace App\Http\Controllers\PasswordDirectory;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*форма для отправки сообщения на почту*/
    public function index()
    {
        return view('ResetDirectory.email');
    }

    /*проверка и отправление на почту сообщения*/
    public function store(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Пользователь с таким email не найден.']);
        }
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => "Сообщение отправлено"])
            : back()->withErrors(['email' => __($status)]);
    }
}
