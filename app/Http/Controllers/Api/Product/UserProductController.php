<?php

namespace App\Http\Controllers\Api\Product;

use App\Models\File;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Product\ProductResources;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Exceptions\ProductNotBelongToUser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\Product\ProductWithFavoriteResources;


class UserProductController extends Controller
{
    
  
    public function store(ProductStoreRequest $request)
    {
        try {
            $data = $request->validated();
            
            $data = $request->except('images');
            $data['user_id'] = $request->user()->id;
            $product = Product::create($data);
               ///image validation
               if ($request->hasFile('images')) {
                    foreach($request->file('images') as $image){
                       //$image = $request->file('images');
                        $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                        $image->move(public_path('upload/product/'), $image_name);
                        $save_url = 'upload/product/'.$image_name;
                        File::create([
                            'product_id'=>$product->id,
                            'path' => $save_url,
                            
                        ]);
                    }
            }
            $success['success'] =true;
            $success['data'] =  new ProductResources($product);
            $success['message'] = __('message.success');
            return response()->json($success, 200);
        } catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function storeIOs(Request $request)
    {
        try {
            $data = $request->all();
           //dd($data);
            $data['user_id'] = $request->user()->id;
            $product = Product::create($data);
            $success['success'] =true;
            $success['data'] =  new ProductResources($product);
            $success['message'] = __('message.success');
            return response()->json($success, 200);
        } catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function storeImage(Request $request)
    {
        try {
              $product = Product::findOrFail($request->product_id);
               if ($request->hasFile('images')) {
                    foreach($request->file('images') as $image){
                       //$image = $request->file('images');
                        $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                        $image->move(public_path('upload/product/'), $image_name);
                        $save_url = 'upload/product/'.$image_name;
                        File::create([
                            'product_id'=>$request->product_id,
                            'path' => $save_url,
                            
                        ]);
                    }
            }
            
            $success['success'] =true;
            $success['data'] =  new ProductResources($product);
            $success['message'] = __('message.success');
            return response()->json($success, 200);
        } catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function index(Request $request){
        try {
            
            $perPage = $request->input('perPage', 10);
            $user_id = $request->user()->id;
            //dd($user_id);
            $Product = Product::where('user_id',$user_id)->orderBy('updated_at','desc')->paginate($perPage);
            $data  = ProductCollection::collection($Product);
           
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

        }catch (ModelNotFoundException $e) {
            // Handle the case where the model is not found
            return response()->json([__('message.deleteNotFound')], 404);
        }catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => $e->getMessage()], 404);
        }
      
    }

    public function show(Request $request){

        try {
            $product = Product::findOrFail($request->id);
            $this->productUserChek($product);
            DB::table('products')->where('id', $request->id)->increment('views');
            $success['success'] =true;
            $success['data'] = new ProductResources($product);
            $success['message'] = __('message.success');
            return response()->json($success,200);

    }catch (ModelNotFoundException $e) {
            // Handle the case where the model is not found
            return response()->json([__('message.deleteNotFound')], 404);
        }catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(ProductUpdateRequest $request,Product $product){

        try {
          //  dd($request->user());
            $data = $request->validated();
            $data = $request->except('images');
            //old request
            $oldproduct= Product::findOrFail($product->id);
            ///image validation
               if ($request->hasFile('images')) {

                //delete old files
                    $files= File::where('product_id', $product->id)->get();
                 	foreach($files as $file){
                      if($file->path){
                      unlink('public/'.$file->path); 
                      }
                    $file->delete();
                    }
                //end delete old files
                //multiple images
                    foreach($request->file('images') as $image){
                       //$image = $request->file('images');
                        $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                        $image->move(public_path('upload/product/'), $image_name);
                        $save_url = 'upload/product/'.$image_name;
                        File::create([
                            'product_id'=>$product->id,
                            'path' => $save_url,
                            
                        ]);
                    }
                }

            //update producct
            $product->update($data);
            $success['success'] =true;
            $success['data'] = new ProductResources($product);
            $success['message'] = __('message.success');
            return response()->json($success, 200);

        }
         catch (ModelNotFoundException $e) {
            // Handle the case where the model is not found
            return response()->json([__('message.deleteNotFound')], 404);
        } 
        catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request , $id)
    {
        try {
            
            $product = Product::findOrFail($id);
    
            if (!$product) {
                return response()->json([__('message.deleteNotFound')], 404);
            }
            
            $this->productUserChek($product);
            $files = File::where('product_id', $product->id)->get();
            // dd($file);
            // Delete the associated file if it exists
            if ($files) {
              foreach($files as $file){
              unlink('public/'.$file->path);
                $file->delete();
              }
            }
    
            $product->delete();
    
            return response()->json([__('message.delete')], 200);
        } catch (ModelNotFoundException $e) {
            // Handle the case where the model is not found
            return response()->json([__('message.deleteNotFound')], 404);
        } catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function sold(Request $request , $id){
        
        try{
            $product = Product::FindOrFail($id);
            $product->update(['salled_or_not' => 1]);
            $success['success'] = true;
            $success['name'] = $product->name;
            $success['message'] = __('message.favourit');
            return response()->json($success, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    //check if this product for this user
    
    public function userMostViews(Request $request, $id){
        try {
            $user = $request->user();
            $perPage = $request->input('perPage', 10);
            $product = Product::where('category_id', $id)
            ->whereHas('favoritedBy', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })
            ->orderByDesc('views')
            ->paginate($perPage);
            $data = ProductWithFavoriteResources::collection($product);
        
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

        }catch (ModelNotFoundException $e) {
            // Handle the case where the model is not found
            return response()->json([__('message.deleteNotFound')], 404);
        }catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => $e->getMessage()], 404);
        }
      
    }
        public function block(Request $request){
        try {
            
            $perPage = $request->input('perPage', 10);
            $user_id = $request->user()->id;
            //dd($user_id);
            $Product = Product::notBlockedByUser($user_id)->orderBy('updated_at','desc')->paginate($perPage);
            $data  = ProductCollection::collection($Product);
           
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

        }catch (ModelNotFoundException $e) {
            // Handle the case where the model is not found
            return response()->json([__('message.deleteNotFound')], 404);
        }catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => $e->getMessage()], 404);
        }
      
    }
  	////
    public function Repost(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            // Check if the product has been reposted within the last week
            $lastRepostDate = $product->updated_at;
            $currentDate = now(); // or use Carbon\Carbon for better date manipulation

            // Calculate the difference in days
            $daysDifference = $currentDate->diffInDays($lastRepostDate);

            // Check if the product can be reposted
            if ($daysDifference >= 7) {
                // Update the 'updated_at' timestamp to the current date and time
                $product->touch();

                $success['success'] = true;
                $success['name'] = $product->name;
                $success['message'] = __('message.success');

                return response()->json($success, 200);
            } else {
                // Product can't be reposted ithin 7 days
              	$success['success'] = false;
                $success['message'] ="لا يمكنك اعادة النشر قبل مرور 7 ايام من تاريخ اخر تعديل";
                return response()->json($success, 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function productUserChek($product)
    {
        
        if(Auth::id() !== $product->user_id){

            throw new ProductNotBelongToUser;
        }
    }
    
    
}
