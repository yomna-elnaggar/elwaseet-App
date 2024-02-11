<?php

namespace App\Http\Controllers\Api\userAuth;

use App\Models\User;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Exception\ClientException;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Validation\ValidationException;
use Twilio\Rest\Client;

class RegisterController extends Controller
{


    public function register(RegisterRequest $request)
    {
        try{
            $newUser = $request->validated();
            $newUser['password'] = Hash::make($newUser['password']);
          	if ($request->country_code) {
              $newUser['country_id'] = Country::where('country_code', $request->country_code)->value('id');
          
          	}
            $user = User::create($newUser);
           /* $code = mt_rand(100000, 999999);

         // Save verification code to user
             $user->forceFill([
                 'mobile_verify_code' => $code,
             ])->save();
     
             // Send verification code via Twilio
             $client = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
             $client->messages->create(
                 $user->mobile_number,
                 [
                     'from' => '+12544002654',
                     'body' => "Your verification code is: $code",
                 ]
             );*/
            $success['success'] = true;
            $success['token'] = $user->createToken('user',['app:all'])->plainTextToken;
            $success['success'] = true;
            $success['name'] = $user->name;
            $success['message'] = __('message.success');
            return response()->json($success, 200);

        }catch (ValidationException $e) {
            // Handle validation errors
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function registerWithSocial(Request $request)
    {
        try{
            $userCreated = User::firstOrCreate(['name' => $request->name ,'social_id' => $request->social_id,]);
            $success['success'] = true;
            $success['token'] =$userCreated->createToken('user',['app:all'])->plainTextToken;
            $success['name'] = $userCreated->name;
            $success['message'] = __('message.successSocial');

            return response()->json($success, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    

    
}
