<?php

namespace App\Http\Controllers\Api\vendor;

use App\Models\Rateing;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Vendor\VendorRateingResource;

class RateingController extends Controller
{
     public function addRating(Request $request,$id)
    {
        try {
            $auth_id =$request->user()->id;
            $data = Rateing::create([
                'comment'=> $request->comment,
                'rate'=>$request->rate,
                'auth_id'=>$auth_id,
                'user_id'=>$id
            ]);
            $success['success'] = true;
            $success['data']  = $data;
            $success['message'] = __('message.success');
            return response()->json($success,200);

        }catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => $e->getMessage()], 500);
        
        }
    }
    
     public function vendorRate($id)
    {
        try {
            
            $data = Rateing::where('user_id',$id)->get();
            
           // dd($Evaluator);
             $avarageStar = 0;
            if($data->count()>0){
               $avarageStar = round($data->sum('rate')/$data->count()); 
            }
            $success['success'] = true;
            $success['data']  = VendorRateingResource::collection($data);
            $success['avarageStar']  = $avarageStar;
            $success['message'] = __('message.success');
            return response()->json($success,200);

        }catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => $e->getMessage()], 500);
        
        }
    }
    
    

}
