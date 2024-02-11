<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Country;
use App\Models\Government;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;



class GovernmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function index()
    {
        $government = Government::with('country')->get();
        return view('backend.government.index', compact('government'));
    }


    public function create()
    {
        $country = Country::get(); 
        return view('backend.government.create', compact('country'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'country_id' => 'required'
        ]);

        Government::create([
            'name'=> json_encode([
                'en'=>$request->name_en,
                'ar'=>$request->name_ar,
            ]),
            'country_id' =>$request->country_id
        ]);
        return redirect()->route('government.all')->with('msg', 'تم اضافة التصنيف');
    }


    public function edit($id)
    {
        $government = Government::find($id);
        $country = Country::get();
        return view('backend.government.edit', compact('government','country'));
    }

    public function update(Request $request,$id)
    {
       
        Government::findOrFail($id)->update([
            'name'=> json_encode([
                'en'=>$request->name_en,
                'ar'=>$request->name_ar,
            ]),
            'country_id' =>$request->country_id,
        ]);

        return redirect()->route('government.all')->with('msg', 'تم تحديث المعلومات');
        
      
    }


    public function destroy(string $id)
    {
        $government = Government::findOrFail($id); 
        $government->delete();
        return redirect()->back()->with('msg', 'تم حذف التصنيف');
    }
}
