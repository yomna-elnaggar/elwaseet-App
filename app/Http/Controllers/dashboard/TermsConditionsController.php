<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TermsConditions;
use App\Http\Resources\TermsConditionsResource;


class TermsConditionsController extends Controller
{
    //termsConditions
    public function __construct()
    {
        $this->middleware('admin')->except('TermsConditions');
    }

    public function index()
    {
        $termsConditions =TermsConditions::get();

        return view('backend.termsConditions.index',compact('termsConditions'));
    }


    public function create()
    {
        return view('backend.termsConditions.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'terms_conditions_ar' => 'required',
            'terms_conditions_en' => 'required'
        ]);
    
        TermsConditions::create([
            'terms_conditions'=> json_encode([
                'en'=>$request->terms_conditions_en,
                'ar'=>$request->terms_conditions_ar,
            ]),
        ]);
    
        return redirect()->route('termsConditions.all')->with('msg', 'تم اضافة شروط واحكام');
       
    }

    public function edit(string $id)
    {
        $termsConditions = TermsConditions::findOrFail($id);
        return view('backend.termsConditions.edit', compact('termsConditions'));
    }

    public function update(Request $request, string $id)
    {
    
        TermsConditions::findOrFail($id)->update([
            'terms_conditions'=> json_encode([
                'en'=>$request->terms_conditions_en,
                'ar'=>$request->terms_conditions_ar,
        ]),
        ]);

        return redirect()->route('termsConditions.all')->with('msg', 'تم تحديث شروط واحكام');
    }

    public function destroy(string $id)
    {
        $privacyPolicy = TermsConditions::findOrFail($id);
        $privacyPolicy->delete();

        return redirect()->back()->with('msg', 'تم حذف شروط واحكام');
    }
  
  /////api get TermsConditions

  
     public function TermsConditions()
    {
        try {
            
            $data = TermsConditions::get();
            $success['success'] = true;
            $success['data'] = TermsConditionsResource::collection($data);
            $success['message'] = __('message.success');
            return response()->json($success, 200);
        }catch (\Exception $e) {
            
            return response()->json(['error' => $e->getMessage()], 500);
        }
  
       
    }
}
