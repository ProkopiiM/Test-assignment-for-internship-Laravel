<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    /*вывод информационной карточки*/
    public function index(Request $request)
    {
        $card = Card::find($request->input('id'));
        return view('information')->with('card', $card);
    }
}
