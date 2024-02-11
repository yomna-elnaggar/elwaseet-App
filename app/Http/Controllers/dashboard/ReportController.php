<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Report;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Vendor\VendorRateingResource;

class ReportController extends Controller
{
       public function addReport(Request $request,$id)
    {
        try {
            $auth_id =$request->user()->id;
            $data = Report::create([
                'comment'=> $request->comment,
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
    
     public function index()
    {
        $Report = Report::get();
		
        return view('backend.Report.index', compact('Report'));
    }
  
   public function destroy(string $id)
    {
        $ContactUs = ContactUs::findOrFail($id);
        $ContactUs->delete();
        return redirect()->back()->with('msg', 'تم حذف الرسالة');
    }
}
