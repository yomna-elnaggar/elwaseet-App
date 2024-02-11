<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Teps;
use function Ramsey\Uuid\v1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class TepsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $Teps = Teps::get();

        return view('backend.teps.index',compact('Teps'));
    }


    public function create()
    {
        return view('backend.teps.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'teps_ar' => 'required',
            'teps_en' => 'required'
        ]);
    
        Teps::create([
            'teps'=> json_encode([
                'en'=>$request->teps_en,
                'ar'=>$request->teps_ar,
            ]),
        ]);
    
        return redirect()->route('Teps.all')->with('msg', 'تم اضافة التصنيف');
       
    }

    public function edit(string $id)
    {
        $Teps = Teps::findOrFail($id);
        return view('backend.teps.edit', compact('Teps'));
    }

    public function update(Request $request, string $id)
    {
    
        Teps::findOrFail($id)->update([
            'teps'=> json_encode([
                'en'=>$request->teps_en,
                'ar'=>$request->teps_ar,
        ]),
        ]);

        return redirect()->route('Teps.all')->with('msg', 'تم تحديث المعلومات');
    }

    public function destroy(string $id)
    {
        $id = Teps::findOrFail($id);
        $id->delete();

        return redirect()->back()->with('msg', 'تم حذف التصنيف');
    }
}
