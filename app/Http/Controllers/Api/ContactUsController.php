<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ContactUs;

class ContactUsController extends Controller
{
     public function contactUs(Request $request)
    {
        
        $user = $request->user();

      $validatedData =  $request->validate([
            'name'   => 'required',
            'email'  => 'required', 
            'mobile_number'  => 'required',
            'message' => 'required',
        ]);
         
         ContactUs::create([
         	'name' =>$validatedData['name'],
           	'email' =>$validatedData['email'],
           	'mobile_number' =>$validatedData['mobile_number'],
            'message' =>$validatedData['message'],
         ]);
         
         
        $success['message'] =__('message.ContactUs') ;
        $success['success'] = true;

        return response()->json($success, 200);
    }
  
  	 public function index()
    {
        $ContactUs = ContactUs::get();
		
        return view('backend.ContactUs.index', compact('ContactUs'));
    }
  
   public function destroy(string $id)
    {
        $ContactUs = ContactUs::findOrFail($id);
        $ContactUs->delete();
        return redirect()->back()->with('msg', 'تم حذف الرسالة');
    }
}
