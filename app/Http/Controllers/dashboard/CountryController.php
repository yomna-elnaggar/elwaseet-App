<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Country;
use function Ramsey\Uuid\v1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $country = Country::get();

        return view('backend.country.index',compact('country'));
    }


    public function create()
    {
        return view('backend.country.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'country_code' => 'required',
        ]);
        Country::create([
                'name'=> json_encode([
                    'en'=>$request->name_en,
                    'ar'=>$request->name_ar,
                ]),
                'country_code'=>$request->country_code
        ]);
        return redirect()->route('country.all')->with('msg', 'تم اضافة دولة');
    }

    public function edit(string $id)
    {
        $country = Country::findOrFail($id);
        return view('backend.country.edit', compact('country'));
    }

    public function update(Request $request, string $id)
    {
        $country_id = $request->id;
        Country::findOrFail($country_id)->update([ 
            'name'=> json_encode([
                'en'=>$request->name_en,
                'ar'=>$request->name_ar,
            ]),
            'country_code'=>$request->country_code
        ]);

        return redirect()->route('country.all')->with('msg', 'تم تحديث المعلومات');
    }


    public function destroy(string $id)
    {
        $country = Country::findOrFail($id);
        $country->delete();

        return redirect()->back()->with('msg', 'تم حذف التصنيف');
    }
}
