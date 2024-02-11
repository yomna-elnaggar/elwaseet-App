<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\SuperCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;



class SubCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function index()
    {
        $subcategory = SubCategory::with('category')->get();
        return view('backend.subcategory.index', compact('subcategory'));
    }


    public function create()
    {
        $SuperCategory = SuperCategory::get(); 
        return view('backend.subcategory.create', compact('SuperCategory'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'category_id' => 'required',
            'supercategory_id'=>'required'
        ]);

        if ($request->file('image')) {
            $image =$request->file('image');
            $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('upload/subCategory/'), $image_name);
            $save_url = 'upload/subCategory/'.$image_name;

            SubCategory::create([
                'name'=> json_encode([
                    'en'=>$request->name_en,
                    'ar'=>$request->name_ar,
                ]),
                'image'   => $save_url,
                'supercategory_id'=>$request->supercategory_id,
                'category_id' =>$request->category_id
            ]);
        }

        return redirect()->route('subcategory.all')->with('msg', 'تم اضافة التصنيف');
    }


    public function edit($id)
    {
        $subcategory = SubCategory::find($id);
        $SuperCategory = SuperCategory::get(); 
        return view('backend.subcategory.edit', compact('subcategory','SuperCategory'));
    }

    public function update(Request $request,$id)
    {
        $old_image = $request->old_image;
       
        if ($request->file('image')) {

            $image = $request->file('image');
            $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('upload/subCategory'), $image_name);
            $save_url = 'upload/subCategory/'.$image_name;

            if ($old_image) {
                
                unlink('public/'.$old_image);
            }
            SubCategory::findOrFail($id)->update([
            
                'name'=> json_encode([
                    'en'=>$request->name_en,
                    'ar'=>$request->name_ar,
                ]),
                'supercategory_id'=>$request->supercategory_id,
                'category_id' =>$request->category_id,
                'image'=> $save_url
            
                ]);
            return redirect()->route('subcategory.all')->with('msg', 'تم تحديث المعلومات');;
        } else {

            SubCategory::findOrFail($id)->update([
                
                
            'name'=> json_encode([
                'en'=>$request->name_en,
                'ar'=>$request->name_ar,
            ]),
            'supercategory_id'=>$request->supercategory_id,
            'category_id' =>$request->category_id,
            'image'=>$old_image
            ]);

                return redirect()->route('subcategory.all')->with('msg', 'تم تحديث المعلومات');
        }

      
    }


    public function destroy(string $id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $img = $subcategory->image;
        if($img){unlink('public/'.$img); }
        
        $subcategory->delete();
        return redirect()->back()->with('msg', 'تم حذف التصنيف');
    }

    public function getCategory($id)
    {
    $categories = Category::where('supercategory_id', $id)->pluck('name', 'id');

    $categories = $categories->map(function ($category) {
        $category = json_decode($category, true);
        return $category['ar'] ??  null;
    });

    return $categories;
    }
}
