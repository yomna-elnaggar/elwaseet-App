<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrivacyPolicy;
use App\Http\Resources\PrivacyPolicyResource;

class PrivacyPolicyController extends Controller
{
    //privacyPolicy
    public function __construct()
    {
        $this->middleware('admin')->except('PrivacyPolicy');
    }

    public function index()
    {
        $privacyPolicy =PrivacyPolicy::get();

        return view('backend.privacyPolicy.index',compact('privacyPolicy'));
    }


    public function create()
    {
        return view('backend.privacyPolicy.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'privacy_policy_ar' => 'required',
            'privacy_policy_en' => 'required'
        ]);
    
        PrivacyPolicy::create([
            'privacy_policy'=> json_encode([
                'en'=>$request->privacy_policy_en,
                'ar'=>$request->privacy_policy_ar,
            ]),
        ]);
    
        return redirect()->route('privacyPolicy.all')->with('msg', 'تم اضافة التصنيف');
       
    }

    public function edit(string $id)
    {
        $privacyPolicy = PrivacyPolicy::findOrFail($id);
        return view('backend.privacyPolicy.edit', compact('privacyPolicy'));
    }

    public function update(Request $request, string $id)
    {
    
        PrivacyPolicy::findOrFail($id)->update([
            'privacy_policy'=> json_encode([
                'en'=>$request->privacy_policy_en,
                'ar'=>$request->privacy_policy_ar,
        ]),
        ]);

        return redirect()->route('privacyPolicy.all')->with('msg', 'تم تحديث المعلومات');
    }

    public function destroy(string $id)
    {
        $privacyPolicy = PrivacyPolicy::findOrFail($id);
        $privacyPolicy->delete();

        return redirect()->back()->with('msg', 'تم حذف التصنيف');
    }
  
  /////api get PrivacyPolicy

  
     public function PrivacyPolicy()
    {
        try {
            
            $data = PrivacyPolicy::get();
            $success['success'] = true;
            $success['data'] = PrivacyPolicyResource::collection($data);
            $success['message'] = __('message.success');
            return response()->json($success, 200);
        }catch (\Exception $e) {
            
            return response()->json(['error' => $e->getMessage()], 500);
        }
  
       
    }
}
