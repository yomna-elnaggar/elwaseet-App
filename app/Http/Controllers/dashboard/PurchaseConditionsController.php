<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PurchaseConditionsResource;
use App\Models\PurchaseConditions;
class PurchaseConditionsController extends Controller
{
      //privacyPolicy
    public function __construct()
    {
        $this->middleware('admin')->except('PurchaseConditions');
    }

    public function index()
    {
        $purchaseConditions =PurchaseConditions::get();

        return view('backend.purchaseConditions.index',compact('purchaseConditions'));
    }


    public function create()
    {
        return view('backend.purchaseConditions.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'purchase_conditions_ar' => 'required',
            'purchase_conditions_en' => 'required'
        ]);
    
        PurchaseConditions::create([
            'purchase_conditions'=> json_encode([
                'en'=>$request->purchase_conditions_en,
                'ar'=>$request->purchase_conditions_ar,
            ]),
        ]);
    
        return redirect()->route('purchaseConditions.all')->with('msg', 'تم اضافة شروط الشراء');
       
    }

    public function edit(string $id)
    {
        $purchaseConditions = PurchaseConditions::findOrFail($id);
        return view('backend.purchaseConditions.edit', compact('purchaseConditions'));
    }

    public function update(Request $request, string $id)
    {
    
        PurchaseConditions::findOrFail($id)->update([
            'purchase_conditions'=> json_encode([
                'en'=>$request->purchase_conditions_en,
                'ar'=>$request->purchase_conditions_ar,
        ]),
        ]);

        return redirect()->route('purchaseConditions.all')->with('msg', 'تم تحديث شروط الشراء');
    }

    public function destroy(string $id)
    {
        $purchaseConditions = PurchaseConditions::findOrFail($id);
        $purchaseConditions->delete();

        return redirect()->back()->with('msg', 'تم حذف شروط الشراء');
    }
  
  /////api get PurchaseConditions

  
     public function PurchaseConditions()
    {
        try {
            
            $data = PurchaseConditions::get();
            $success['success'] = true;
            $success['data'] = PurchaseConditionsResource::collection($data);
            $success['message'] = __('message.success');
            return response()->json($success, 200);
        }catch (\Exception $e) {
            
            return response()->json(['error' => $e->getMessage()], 500);
        }
  
       
    }
}
