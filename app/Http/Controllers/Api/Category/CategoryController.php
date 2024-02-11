<?php

namespace App\Http\Controllers\Api\Category;

use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\SuperCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Category\SuperCategoryResource;

class CategoryController extends Controller
{
    
    public function index(){
        try {
            
            $data = SuperCategory::with('categories')->get();
            $success['success'] = true;
            $success['data'] = SuperCategoryResource::collection($data);
            $success['message'] = __('message.success');
            return response()->json($success, 200);
        }catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function subCategory($id){
        try {
            $data = SubCategory::where('category_id',$id)->get();
            $data = CategoryResource ::collection($data);
            return response()->json([
            'success' => true,
            'data' => $data,
            'message' => __('message.success'),
            ], 200);
        }catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function catProduct(Request $request,$id){
        try {
            
            $perPage = $request->input('perPage', 10);
            $data = Product::where('category_id',$id)->paginate($perPage);
            $data = ProductCollection::collection($data);
            return response()->json([
            'success' => true,
            'data' => $data,
                'pagination' => [
                    'current_page' => $data->currentPage(),
                    'last_page' => $data->lastPage(),
                    'per_page' => $data->perPage(),
                    'total' => $data->total(),
                ],
            'message' => __('message.success'),
            ], 200);
        }catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function catWithSubProduct(Request $request,$catId,$subId){
        try {
            
            $perPage = $request->input('perPage', 10);
            $data = Product::where('category_id',$catId)->where('subcategory_id',$subId)->paginate($perPage);
            $data = ProductCollection::collection($data);
            return response()->json([
            'success' => true,
            'data' => $data,
                'pagination' => [
                    'current_page' => $data->currentPage(),
                    'last_page' => $data->lastPage(),
                    'per_page' => $data->perPage(),
                    'total' => $data->total(),
                ],
            'message' => __('message.success'),
            ], 200);
        }catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
