<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeviceTokrnController extends Controller
{
       public function store(Request $request)
    {
        
        $user = $request->user();
 		$exists= $user->deviceTokens()->where('token',$request->token)->exists();
         if(!$exists){
     	$user->deviceTokens()->create([
         	'token' =>$request->token ,
           	'device_name' =>$request->device_name,
         ]);
        }
         
        $success['message'] =('success') ;
        $success['success'] = true;

        return response()->json($success, 200);
    }
  
  
  	public function showOne(Request $request)
    {
        try {
            $user = $request->user();
          	$Data = $user->
            $success['success'] = true;
            $success['data'] = $Data;
            $success['message'] = __('message.success');
            return response()->json($success, 200);
        }catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
