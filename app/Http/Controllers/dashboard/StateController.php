<?php

namespace App\Http\Controllers\dashboard;

use App\Models\State;
use App\Models\Country;
use App\Models\Category;
use App\Models\Government;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\SuperCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;



class StateController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function index()
    {
        $state = State::with('country')->get();
        return view('backend.state.index', compact('state'));
    }


    public function create()
    {
        $Country = Country::get(); 
        return view('backend.state.create', compact('Country'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'country_id' => 'required',
            'government_id'=>'required'
        ]);

        State::create([
            'name'=> json_encode([
                'en'=>$request->name_en,
                'ar'=>$request->name_ar,
            ]),
            'country_id'=>$request->country_id,
            'government_id' =>$request->government_id
        ]);
        return redirect()->route('state.all')->with('msg', 'تم اضافة المنطقة');
    }


    public function edit($id)
    {
        $state = State::find($id);
        $Country = Country::get(); 
        return view('backend.state.edit', compact('state','Country'));
    }

    public function update(Request $request,$id)
    {
        State::findOrFail($id)->update([
        'name'=> json_encode([
            'en'=>$request->name_en,
            'ar'=>$request->name_ar,
        ]),
        'country_id'=>$request->country_id,
        'government_id' =>$request->government_id
        ]);

        return redirect()->route('state.all')->with('msg', 'تم تحديث المعلومات');
    }


    public function destroy(string $id)
    {
        $state = State::findOrFail($id); 
        $state->delete();
        return redirect()->back()->with('msg', 'تم حذف التصنيف');
    }

    public function getGovernment($id)
    {
    $governmentes = Government::where('country_id', $id)->pluck('name', 'id');
    $governmentes = $governmentes->map(function ($government) {
        $government = json_decode($government, true);
        return $government['ar'] ??  null;
    });

    return $governmentes;
    }
}
