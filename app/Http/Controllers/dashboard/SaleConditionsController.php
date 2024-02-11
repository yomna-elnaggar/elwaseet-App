<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SaleConditions;
use App\Http\Resources\SaleConditionsResource;
class SaleConditionsController extends Controller
{
     //privacyPolicy
    public function __construct()
    {
        $this->middleware('admin')->except('SaleConditions');
    }

    public function index()
    {
        $saleConditions =SaleConditions::get();

        return view('backend.saleConditions.index',compact('saleConditions'));
    }


    public function create()
    {
        return view('backend.saleConditions.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'sale_conditions_ar' => 'required',
            'sale_conditions_en' => 'required'
        ]);
    
        SaleConditions::create([
            'sale_conditions'=> json_encode([
                'en'=>$request->sale_conditions_en,
                'ar'=>$request->sale_conditions_ar,
            ]),
        ]);
    
        return redirect()->route('saleConditions.all')->with('msg', 'تم اضافة التصنيف');
       
    }

    public function edit(string $id)
    {
        $saleConditions = SaleConditions::findOrFail($id);
        return view('backend.saleConditions.edit', compact('saleConditions'));
    }

    public function update(Request $request, string $id)
    {
    
        SaleConditions::findOrFail($id)->update([
            'sale_conditions'=> json_encode([
                'en'=>$request->sale_conditions_en,
                'ar'=>$request->sale_conditions_ar,
        ]),
        ]);

        return redirect()->route('saleConditions.all')->with('msg', 'تم تحديث المعلومات');
    }

    public function destroy(string $id)
    {
        $saleConditions = SaleConditions::findOrFail($id);
        $saleConditions->delete();

        return redirect()->back()->with('msg', 'تم حذف التصنيف');
    }
  
  /////api get SaleConditions

  
     public function SaleConditions()
    {
        try {
            
            $data = SaleConditions::get();
            $success['success'] = true;
            $success['data'] = SaleConditionsResource::collection($data);
            $success['message'] = __('message.success');
            return response()->json($success, 200);
        }catch (\Exception $e) {
            
            return response()->json(['error' => $e->getMessage()], 500);
        }
  
       
    }
}
