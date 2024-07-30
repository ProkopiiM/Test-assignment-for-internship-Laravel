<?php

namespace App\Http\Controllers\AdminDirectory\ManagmentComponents;

use App\Http\Controllers\Controller;
use App\Models\Manufacture;
use Illuminate\Http\Request;

class ManagmentManufacturerController extends Controller
{
    public function show($id)
    {
        return view('AdminDirectory.ManagmentComponents.ManufacturerManagment.manufacturer-view',['manufacturer'=>Manufacture::where('id',$id)->first()]);
    }
    public function update($id, Request $request)
    {
        Manufacture::where('id',$id)->update(['name'=>$request->input('title')]);
        return redirect('/admin-panel/manufacturers');
    }
    public function destroy($id)
    {
        Manufacture::where('id',$id)->delete();
        return redirect('/admin-panel/manufacturers');
    }
    public function create()
    {
        return view('AdminDirectory.ManagmentComponents.ManufacturerManagment.manufacturer-create',['manufacturer'=>null]);
    }
    public function store(Request $request)
    {
        Manufacture::create([
            'name'=>$request->input('title'),
        ]);
        return redirect('/admin-panel/manufacturers');
    }
}
