<?php

namespace App\Http\Controllers\Api\vendor;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    public function favourit($id){
        try{
            $vendor = User::FindOrFail($id);
            $vendor->update(['favorite' => 1]);
            $success['success'] = true;
            $success['name'] = $vendor->name;
            $success['message'] = __('message.favourit');
            return response()->json($success, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
