<?php

namespace App\Http\Controllers\Api\Product;

use App\Models\File;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Product\ProductResources;
use App\Http\Resources\Product\ProductCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
   
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('perPage', 10);
            $data = ProductCollection::collection(Product::orderBy('updated_at','desc')->paginate($perPage));
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

    public function show(Request $request)
    {
        try {
            $product = Product::findOrFail($request->id);
            //dd($product->Contact_by_phone);
            if($product){
            DB::table('products')->where('id', $request->id)->increment('views');
            $success['success'] = true;
            $success['data'] = new ProductResources($product);
            $success['message'] = __('message.success');
            return response()->json($success,200);
            }

        }catch (ModelNotFoundException $e) {
            // Handle the case where the model is not found
            return response()->json([__('message.deleteNotFound')], 404);
        }catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function cityProduct(Request $request)
    {
        try {
            $perPage = $request->input('perPage', 10);
            $data = Product::where('state_id',$request->state_id)->orderBy('updated_at','desc')->paginate($perPage);
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
    
    public function mostViews(Request $request)
    {
       
    try {
        $perPage = $request->input('perPage', 10);
        $data = ProductCollection::collection(Product::orderBy('views', 'desc')->paginate($perPage));
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
    } catch (\Exception $e) {
        // Log the exception or handle it appropriately
        return response()->json(['error' => $e->getMessage()], 500);
    }
    }

    
    
  
}
