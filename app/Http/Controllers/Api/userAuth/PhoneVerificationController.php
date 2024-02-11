<?php

namespace App\Http\Controllers\Api\userAuth;

use Illuminate\Http\Request;
use Twilio\TwiML\VoiceResponse;
use App\Http\Controllers\Controller;

class PhoneVerificationController extends Controller
{
    public function verify(Request $request)
    {
        // Validate request
        $user = $request->user();
        // Verify user with provided code
        if ($user->mobile_verify_code !== $request->code) {
            return response()->json(['error' => 'Invalid code'], 422);
        }

        if ($user->userPhoneVerified()) {
            return response()->json(['error' => 'Phone already verified'], 422);
        }

        $user->phoneVerifiedAt();

        return response()->json(['message' => 'Phone verified successfully']);
    }

    public function buildTwiMl($code)
    {
        $code = $this->formatCode($code);
        $response = new VoiceResponse();
        $response->say("Hello, This is your verification code. $code.");

        return response($response, 200)->header('Content-Type', 'text/xml');
    }

    public function formatCode($code)
    {
        $collection = collect(str_split($code));
        return $collection->reduce(
            function ($carry, $item) {
                return "{$carry}. {$item}";
            }
        );
    }
}
