<?php

namespace App\Http\Controllers\Api;

use App\Models\Notification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        try {
            $receiver_id = $request->receiver_id;
            $data = Notification::where('user_id',$receiver_id)->orderby('id','desc')->get();
            $success['success'] = true;
            $success['data'] = $data;
            $success['message'] = __('message.success');
            return response()->json($success, 200);
        }catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
  	public function showOne(Request $request)
    {
        try {
            $user = $request->user();
          	$notification_id = $request->id;
            $data = Notification::where('id', $request->id)->update(['status' => 1]);
            $updatedData = Notification::where('id', $request->id)->first();
            $success['success'] = true;
            $success['data'] = $updatedData;
            $success['message'] = __('message.success');
            return response()->json($success, 200);
        }catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
   	public function unread(Request $request)
    {
        try {
            $receiver_id = $request->receiver_id;
          	$data = Notification::where('user_id', $receiver_id)->where('status', 0)->orderBy('id', 'desc')->get();
            $success['success'] = true;
            $success['data'] = $data;
            $success['message'] = __('message.success');
            return response()->json($success, 200);
        }catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
  
  	public function store(Request $request)
    {
       $user = $request->user();
       $validatedData= $request->validate([
            'name' 		 => 'required',
            'body' 		 => 'required',
         	'receiver_id'=> 'required',
        ]);

       

             $data= Notification::create([
                'name'   =>$validatedData['name'] ,
                'body'   =>$validatedData['body'] ,
                'user_id'=>$validatedData['receiver_id'], 
            ]);
          
            $success['success'] =true;
            $success['data'] =  $data;
            $success['message'] = __('message.success');
            return response()->json($success, 200);
       
      }
  
  
  
  
  		
  
   

}
