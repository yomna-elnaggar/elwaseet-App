<?php

namespace App\Http\Controllers\Api\userAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    // UserController.php

public function changePassword(Request $request)
{
    $user = $request->user(); // Get the authenticated user

    // Validate the request data
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:6|confirmed',
    ]);

    // Check if the current password matches the user's password
    if (!password_verify($request->current_password, $user->password)) {
            $success['success'] =  false;
            $success['message'] = __('message.passwordIncorrect');
        return response()->json($success, 401);
    }

    // Update the user's password
    $user->update([
        'password' => bcrypt($request->new_password),
    ]);

        $success['success'] =  true;
        $success['message'] = __('message.PasswordChangedSuccessfully');

    return response()->json($success ,200);
}

}
