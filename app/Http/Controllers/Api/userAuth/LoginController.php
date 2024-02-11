<?php

namespace App\Http\Controllers\Api\userAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
  
    public function login(LoginRequest $request)
    {
        // Validate the request
        $request->validate([
            'mobile_number' => 'required',
            'password' => 'required',

        ]);

        $credentials = [
            'mobile_number' => $request->mobile_number,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
              $user = Auth::user();
            if($request->fcm_token)
            {
              if ($user->fcm_token !== $request->fcm_token || $user->fcm_token  == null ) {

                  $user->update(['fcm_token' => $request->fcm_token]);
              }
            }

            // Revoke all existing tokens for the user
            $user->tokens()->delete();

            // Create a new token
            $token = $user->createToken(request()->userAgent())->plainTextToken;

            $response = [
                'success' => true,
                'token' => $token,
                'id' => $user->id,
                'name' => $user->name,
                'message' => __('message.success'),
            ];

            return response()->json($response, 200);
        } else {
            return response()->json(['error' => __('auth.Unauthorised')], 401);
        }
    }
    
     public function username()
    {
    return 'mobile_number';
    }
}
