<?php

namespace App\Http\Controllers\Api\userAuth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Twilio\Rest\Client;


class ForgotPasswordController extends Controller
{
    public function sendVerificationCode(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|numeric|exists:users,mobile_number',
        ]);
    
        $user = User::where('mobile_number', $request->input('mobile_number'))->first();
    
        // Generate a 6-digit verification code
        $verificationCode = mt_rand(100000, 999999);
    
        // Save the verification code in the user record
        $user->update(['mobile_verify_code' => $verificationCode]);
    
        // Send SMS with Twilio
        $this->sendSms($user->mobile_number, $verificationCode);
    
        return response()->json(['message' => 'Verification code sent successfully']);
    }

    public function verifyCode(Request $request)
    {
        // Validate the request
        $request->validate([
            'mobile_number' => 'required|numeric|exists:users,mobile_number',
            'code' => 'required|numeric',
            'password' => 'required|min:6',
        ]);

        $user = User::where('mobile_number', $request->input('mobile_number'))->first();

        // Check if the verification code matches
        if ($user->mobile_verify_code != $request->input('code')) {
            return response()->json(['error' => 'Invalid verification code'], 422);
        }

        // Reset the user's password
        $user->update(['password' => bcrypt($request->input('password'))]);

        // Clear the verification code
        $user->update(['mobile_verify_code' => null]);

        return response()->json(['message' => 'Password reset successfully']);
    }

    private function sendSms($to, $verificationCode)
    {
        $twilioSid = env('TWILIO_SID');
        $twilioAuthToken = env('TWILIO_AUTH_TOKEN');
        $twilioPhoneNumber = '+12544002654';

        $client = new Client($twilioSid, $twilioAuthToken);

       $client->messages->create(
            $to,
            [
                'from' => '+12544002654',
                'body' => "Your verification code is: $verificationCode",
            ]
        );
    }
}

