<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\AdsRolesResource;
use App\Models\AdsRoles;

class AdsRolesController extends Controller
{
          //privacyPolicy
    public function __construct()
    {
        $this->middleware('admin')->except('AdsRoles');
    }

    public function index()
    {
        $adsRoles =AdsRoles::get();

        return view('backend.adsRoles.index',compact('adsRoles'));
    }


    public function create()
    {
        return view('backend.adsRoles.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'ads_roles_ar' => 'required',
            'ads_roles_en' => 'required'
        ]);
    
        AdsRoles::create([
            'ads_roles'=> json_encode([
                'en'=>$request->ads_roles_en,
                'ar'=>$request->ads_roles_ar,
            ]),
        ]);
    
        return redirect()->route('adsRoles.all')->with('msg', 'تم اضافة شروط الاعلان');
       
    }

    public function edit(string $id)
    {
        $adsRoles = AdsRoles::findOrFail($id);
        return view('backend.adsRoles.edit', compact('adsRoles'));
    }

    public function update(Request $request, string $id)
    {
    
        AdsRoles::findOrFail($id)->update([
            'ads_roles'=> json_encode([
                'en'=>$request->ads_roles_en,
                'ar'=>$request->ads_roles_ar,
        ]),
        ]);

        return redirect()->route('adsRoles.all')->with('msg', 'تم تحديث شروط الاعلان');
    }

    public function destroy(string $id)
    {
        $adsRoles = AdsRoles::findOrFail($id);
        $adsRoles->delete();

        return redirect()->back()->with('msg', 'تم حذف شروط الاعلان');
    }
  
  /////api get PurchaseConditions

  
     public function AdsRoles()
    {
        try {
            
            $data = AdsRoles::get();
            $success['success'] = true;
            $success['data'] = AdsRolesResource::collection($data);
            $success['message'] = __('message.success');
            return response()->json($success, 200);
        }catch (\Exception $e) {
            
            return response()->json(['error' => $e->getMessage()], 500);
        }
  
       
    }
}
