<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $product = Product::with('category')->get();

        return view('backend.products.index', compact('product'));
    }


    public function create()
    {
        $category = Category::get();
        return view('backend.products.create', compact('category'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'cate_id' => 'required',
        ]);

        if($request->hasFile('picture')){
            $time = time();
            Image::make($request->file('picture')->getRealPath())->encode('webp', 100)->resize(150, 150)->save(public_path('picProducts/' .  $time . '.webp'));
            Product::create([
                'cate_id'               => $request->input('cate_id'),
                'name'                  => $request->input('name'),
                'slug'                  => $request->input('slug'),
                'description'           => $request->input('description'),
                'original_price'        => $request->input('original_price'),
                'qty'                   => $request->input('qty'),
                'status'                => $request->input('status') == TRUE ? '1' : '0',
                'picture'               => $time . '.' .'webp',

            ]);
        }
        else {
            $time = Null;
            Product::create([
                'cate_id'            => $request->input('cate_id'),
                'name'                  => $request->input('name'),
                'slug'                  => $request->input('slug'),
                'description'           => $request->input('description'),
                'original_price'        => $request->input('original_price'),
                'qty'                   => $request->input('qty'),
                'status'                => $request->input('status') == TRUE ? '1' : '0',
                'picture'               => $time,

            ]);
        }

        return redirect()->route('product.all')->with('msg', 'تم اضافة المنتج');
    }


    // public function show(string $id)
    // {
    //     //
    // }


    public function edit($id)
    {
        $product = Product::find($id);
        $category = Category::get();

        return view('backend.products.edit', compact('category', 'product'));
    }


    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if($request->hasFile('picture')){
            $path = str_replace('\\' , '/' ,public_path('picProducts/')).$product->picture;
            if(File::exists($path)){
                File::delete($path);
            }
            $time = time();
            Image::make($request->file('picture')->getRealPath())->encode('webp', 100)->resize(150, 150)->save(public_path('picProducts/' .  $time . '.webp'));

            DB::table('products')->update([
                'picture' => $time . '.' .'webp',
            ]);
        }
        else {

            $product->cate_id = $request->input('cate_id');
            $product->name       = $request->input('name');
            $product->slug       = $request->input('slug');
            $product->small_description  = $request->input('small_description');
            $product->description       = $request->input('description');
            $product->original_price     = $request->input('original_price');
            $product->selling_price      = $request->input('selling_price');
            $product->qty                = $request->input('qty');
            $product->tax                = $request->input('tax');
            $product->meta_title         = $request->input('meta_title');
            $product->meta_keywords      = $request->input('meta_keywords');
            $product->meta_description   = $request->input('meta_description');
            $product->status             = $request->input('status') == TRUE ? '1' : '0';
            $product->update();
        }

        return redirect()->route('product.all')->with('msg', 'تم تحديث المنتج');
    }


    public function destroy($id)
    {
        $product = Product::find($id);
        $path = str_replace('\\' , '/' ,public_path('picProducts/')).$product->picture;
        if(File::exists($path)){
            File::delete($path);
        }
        $product->delete();

        return redirect()->route('product.all')->with('msg', 'تم حذف المنتج');
    }
}
