<?php

namespace App\Http\Controllers\Api;

use App\Models\Teps;
use Illuminate\Http\Request;
use App\Http\Resources\TepResource;
use App\Http\Controllers\Controller;

class TepsApiController extends Controller
{
    public function index(){
        try {
            
            $data = Teps::get();
            $success['success'] = true;
            $success['data'] = TepResource::collection($data);
            $success['message'] = __('message.success');
            return response()->json($success, 200);
        }catch (\Exception $e) {
            
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
