<?php

namespace App\Http\Controllers\Api\userAuth;

use App\Models\User;
use App\Models\Country;
use App\Models\Government;
use App\Models\Product;
use App\Models\File;
use Illuminate\Http\Request;
use App\Traits\ImageProcessing;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResources;
use App\Http\Resources\User\UserUpdateResource;
use App\Http\Requests\Auth\UpdateProfileRequest;

class ProfileController extends Controller
{
    use ImageProcessing;

    public function profile(Request $request){
        
        try {
            $user = $request->user();
            $success['success'] = true;
            $success['data'] =  new UserResources($user);
            $success['message'] = __('message.success');
            return response()->json($success, 200);
        }catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => __($e->getMessage())], 500);
        }
    }

    public function update( UpdateProfileRequest $request){
       
        try {
            $user = $request->user();
            $validatedData =  $request->validated();

            if($request->hasFile('image')){
                $image = $request->file('image');
                $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                $image->move(public_path('upload/user'), $image_name);
                $save_url = 'upload/user/'.$image_name;
    
                $validatedData['image'] = $save_url; 
            }

            if ($request->country_code) {
              $validatedData['country_code'] = $request->country_code;
              $validatedData['country_id'] = Country::where('country_code', $request->country_code)->value('id');
          
          	}

          	
            $user->update($validatedData);
            
            $success['success'] = true;
            $success['user'] = new UserUpdateResource($user);
            $success['message'] = __('message.success');
            return response()->json($success, 200);
           
        }catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => __($e->getMessage())], 500);
        }
        
    }
    
    public function destroy(Request $request){

        try {
            $user =$request->user();
          	$products= Product::where('user_id',$user->id)->get();
          	foreach($products as $product){
             	$files = File::where('product_id', $product->id)->get();
            // dd($file);
            // Delete the associated file if it exists
            if ($files) {
              foreach($files as $file){
              unlink('public/'.$file->path);
                $file->delete();
              }
            }
            }
         
            $user->delete();
           
            return response()->json([__('message.destroy')], 200);
        }catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => __($e->getMessage())], 500);
        }

    
    }
}
