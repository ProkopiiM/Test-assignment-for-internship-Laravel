<?php

namespace App\Http\Controllers\AuthDirectory;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthAdminController extends Controller
{
    /*форма для авторизации в админ панели*/
    public function index()
    {
        return view('AdminDirectory.AuthAdmin.auth_admin');
    }

    /*авторизация в админ панели*/
    public function store(Request $request)
    {
        $user = User::where('email', $request->email)->whereIn('role_id', [1,2])->first();
        if (!empty($user))
        {
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('admin-panel.index');
            } else {
                return redirect()->back()->with('error', 'Неверный логин или пароль');
            }
        }
    }

    /*выход из админ панели*/
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.index');
    }
}
