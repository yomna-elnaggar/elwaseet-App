<?php

namespace App\Http\Controllers\Api\vendor;

use App\Models\Product;
use App\Http\Resources\Product\ProductResources;
use App\Http\Resources\Vendor\VendorResource;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function vendor($id)
    {
        try{
            $vendor = User::FindOrFail($id);
            if($vendor){
                $success['success'] = true;
                $success['vendor'] = new VendorResource($vendor);
                $success['message'] = __('message.success');
                return response()->json($success, 200);
            }
        }catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        
        }
    }
    
   public function vendorProduct(Request $request,$id)
    {
        try{
            $vendor = User::FindOrFail($id);
            $perPage = $request->input('perPage', 10);
            $vendorProduct = Product::where('user_id',$id)->orderBy('id','desc')->paginate($perPage);
            $data = ProductResources::collection($vendorProduct);
           // dd($vendorProduct);
            if($vendorProduct){
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
            }
        }catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        
        }
    }
}
