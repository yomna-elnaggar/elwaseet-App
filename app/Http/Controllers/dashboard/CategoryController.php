<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\SuperCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;



class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function index()
    {
        $category = Category::with('superCategory')->get();
        return view('backend.category.index', compact('category'));
    }


    public function create()
    {
        $SuperCategory = SuperCategory::get(); 
        return view('backend.category.create', compact('SuperCategory'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'supercategory_id' => 'required'
        ]);

        if ($request->file('image')) {
            $image =$request->file('image');
            $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('upload/category/'), $image_name);
            $save_url = 'upload/category/'.$image_name;

            Category::create([
                'name'=> json_encode([
                    'en'=>$request->name_en,
                    'ar'=>$request->name_ar,
                ]),
                'image'   => $save_url,
                'supercategory_id' =>$request->supercategory_id
            ]);
        }

        return redirect()->route('category.all')->with('msg', 'تم اضافة التصنيف');
    }


    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $SuperCategory = SuperCategory::get();
        return view('backend.category.edit', compact('SuperCategory','category'));
    }

    public function update(Request $request,$id)
    {
        $old_image = $request->old_image;
       
        if ($request->file('image')) {

            $image = $request->file('image');
            $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('upload/category'), $image_name);
            $save_url = 'upload/category/'.$image_name;

            if ($old_image) {
                
                unlink('public/'.$old_image);
            }
            Category::findOrFail($id)->update([
            
                'name'=> json_encode([
                    'en'=>$request->name_en,
                    'ar'=>$request->name_ar,
                ]),
                'supercategory_id' =>$request->supercategory_id,
                'image'=> $save_url
            
                ]);
            return redirect()->route('category.all')->with('msg', 'تم تحديث المعلومات');;
        } else {

            Category::findOrFail($id)->update([
                
                
            'name'=> json_encode([
                'en'=>$request->name_en,
                'ar'=>$request->name_ar,
            ]),
            'supercategory_id' =>$request->supercategory_id,
            'image'=>$old_image
            ]);

                return redirect()->route('category.all')->with('msg', 'تم تحديث المعلومات');
        }

      
    }


    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $img = $category->image;
        if($img){unlink('public/'.$img );}
        $category->delete();
        return redirect()->back()->with('msg', 'تم حذف التصنيف');
    }
}
