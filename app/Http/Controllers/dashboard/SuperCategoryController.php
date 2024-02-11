<?php

namespace App\Http\Controllers\dashboard;

use function Ramsey\Uuid\v1;
use Illuminate\Http\Request;
use App\Models\SuperCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class SuperCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $SuperCategory = SuperCategory::get();

        return view('backend.superCategory.index',compact('SuperCategory'));
    }


    public function create()
    {
        return view('backend.superCategory.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required'
        ]);
    
        SuperCategory::create([
            'name'=> json_encode([
                'en'=>$request->name_en,
                'ar'=>$request->name_ar,
            ]),
        ]);
    
        return redirect()->route('SuperCategory.all')->with('msg', 'تم اضافة التصنيف');
       
    }

    public function edit(string $id)
    {
        $SuperCategory = SuperCategory::findOrFail($id);
        return view('backend.superCategory.edit', compact('SuperCategory'));
    }

    public function update(Request $request, string $id)
    {
    
        SuperCategory::findOrFail($id)->update([
        'name'=> json_encode([
            'en'=>$request->name_en,
            'ar'=>$request->name_ar,
        ]),
        ]);

        return redirect()->route('SuperCategory.all')->with('msg', 'تم تحديث المعلومات');
    }

    public function destroy(string $id)
    {
        $id = SuperCategory::findOrFail($id);
        $id->delete();

        return redirect()->back()->with('msg', 'تم حذف التصنيف');
    }
}
