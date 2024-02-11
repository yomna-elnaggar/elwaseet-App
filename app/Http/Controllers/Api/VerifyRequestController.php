<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\VerifayRequest;

class VerifyRequestController extends Controller
{
       public function verifyRequest(Request $request)
    {
        
        $user = $request->user();

      $validatedData =  $request->validate([
            'name'   => ['required', Rule::in([$user->name])],
            'email'  => ['required', Rule::in([$user->email])],
            'mobile_number'  => ['required', Rule::in([$user->mobile_number])],
            'reason' => 'required',
            'image'  => 'required',
        ]);
         
		 if ($request->file('image')) {
            $image =$request->file('image');
            $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('upload/verify/'), $image_name);
            $save_url = 'upload/verify/'.$image_name;
         
         VerifayRequest::create([
         	'user_id'=>$user->id,
           	'reason' =>$validatedData['reason'],
           	'image' =>$save_url,
         ]);
         }
         
        $success['message'] =__('message.verifyRequst') ;
        $success['success'] = true;

        return response()->json($success, 200);
      }
  
  	 public function index()
    {
        $verifayRequest = VerifayRequest::with('user')->get();
		
        return view('backend.verifyrequest.index', compact('verifayRequest'));
    }
  
   public function verify(string $id)
    {
        $VerifayRequest = VerifayRequest::findOrFail($id);
     	$user= $VerifayRequest->user;
        $user->update([
          'Verified'=>1	
          ]);
        $img = $VerifayRequest->image;
        if($img){unlink('public/'.$img );}
        $VerifayRequest->delete();
        return redirect()->back()->with('msg', 'تم توثيق الحساب');
    }

}
