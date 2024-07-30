<?php

namespace App\Http\Controllers\AdminDirectory;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /*главная страница админ панели*/
    public function index()
    {
        return view('AdminDirectory.main-admin-panel');
    }
}
