<?php

namespace App\Http\Controllers\Api\userAuth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;

class ForgotPasswordByEmailController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email not found'], 404);
        }

        $token = mt_rand(100000, 999999); // Generate a 6-digit OTP

        // Save the token to the user record
        $user->update([
            'reset_token' => $token,
            'reset_token_expiry' => now()->addMinutes(60), 
        ]);

        // Send the OTP directly in the email
        $user->sendPasswordResetNotification($token);
		
        return response()->json(['success'=> true,'message' => 'Reset password OTP sent']);
    }

public function validateResetToken(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'token' => 'required|string',
    ]);

    $user = User::where('email', $request->email)
        ->where('reset_token', $request->token)
        ->where('reset_token_expiry', '>=', now())
        ->first();

    if (!$user) {
        return response()->json(['success' => false, 'message' => 'Invalid email or token'], 400);
    }

    return response()->json(['success' => true, 'message' => 'Token is valid', 'user' => $user], 200);
}

 public function completeResetPassword(Request $request)
{
    try {
          $request->validate([
          'email' => 'required|email',
          'token' => 'required|string',
          'password' => 'required|string|min:6',
          ]);

          $user = User::where('email', $request->email)
              ->where('reset_token', $request->token)
              ->where('reset_token_expiry', '>=', now())
              ->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid email or token'], 400);
        }


        $user->update([
            'password' => bcrypt($request->password),
            'reset_token' => null,
            'reset_token_expiry' => null,
        ]);

        return response()->json(['message' => 'Password reset successfully']);
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 400);
    }
}



}
