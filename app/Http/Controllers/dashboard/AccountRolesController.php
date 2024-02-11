<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\AccountRolesResource;
use App\Models\AccountRoles;

class AccountRolesController extends Controller
{
     public function __construct()
    {
        $this->middleware('admin')->except('AccountRoles');
    }

    public function index()
    {
        $accountRoles =AccountRoles::get();

        return view('backend.accountRoles.index',compact('accountRoles'));
    }


    public function create()
    {
        return view('backend.accountRoles.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'account_roles_ar' => 'required',
            'account_roles_en' => 'required'
        ]);
    
        AccountRoles::create([
            'account_roles'=> json_encode([
                'en'=>$request->account_roles_en,
                'ar'=>$request->account_roles_ar,
            ]),
        ]);
    
        return redirect()->route('accountRoles.all')->with('msg', 'تم اضافة شروط الحساب');
       
    }

    public function edit(string $id)
    {
        $accountRoles = AccountRoles::findOrFail($id);
        return view('backend.accountRoles.edit', compact('accountRoles'));
    }

    public function update(Request $request, string $id)
    {
    
        AccountRoles::findOrFail($id)->update([
            'account_roles'=> json_encode([
                'en'=>$request->account_roles_en,
                'ar'=>$request->account_roles_ar,
        ]),
        ]);

        return redirect()->route('accountRoles.all')->with('msg', 'تم تحديث شروط الحساب');
    }

    public function destroy(string $id)
    {
        $purchaseConditions = AccountRoles::findOrFail($id);
        $purchaseConditions->delete();

        return redirect()->back()->with('msg', 'تم حذف شروط الحساب');
    }
  
  /////api get PurchaseConditions

  
     public function AccountRoles()
    {
        try {
            
            $data = AccountRoles::get();
            $success['success'] = true;
            $success['data'] = AccountRolesResource::collection($data);
            $success['message'] = __('message.success');
            return response()->json($success, 200);
        }catch (\Exception $e) {
            
            return response()->json(['error' => $e->getMessage()], 500);
        }
  
       
    }
}
