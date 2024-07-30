<?php

namespace App\Http\Controllers\AdminDirectory\ManagmentComponents;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;

class ManagmentInformationController extends Controller
{
    /*для формы создания информационной карточки*/
    public function index()
    {
        return view('AdminDirectory.ComponentManagment.InformationManagment..information-view',['card'=>null]);
    }


    /*для формы редактирования информационной карточки*/
    public function create(Request $request)
    {
        return view('AdminDirectory.ComponentManagment.InformationManagment..information-view',['card'=>Card::where('id',$request->input('id'))->first()]);
    }

    /*для создания информационной карточки*/
    public function store(Request $request)
    {
        $title = $request->input('title');
        $description = $request->input('description');
        $status = $request->input('status');
        foreach (Card::all() as $card) {
            if ($card->title == $title) {
                return redirect()->back('set','Такая карточка уже существует');
            }
        }
        $card = new Card();
        $card->title = $title;
        $card->description = $description;
        $card->status = $status;
        $card->save();
        return redirect('/admin-panel/information');
    }

    /*для обновления информационной карточки*/
    public function update(Request $request)
    {
        $id = $request->input('id');
        Card::where('id',$id)->update(['description'=>$request->input('description'), 'status'=>$request->input('status')]);
        return redirect('/admin-panel/information');
    }

    /*для удаления информационной карточки*/
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        Card::where('id',$id)->delete();
        return redirect()->back();
    }
}
