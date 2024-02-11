<?php

namespace App\Http\Controllers\Api\Mute;

use App\Models\Mute;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\User\MutedResources;


class MuteController extends Controller
{
     public function muteUser(Request $request, $mutedUserId)
    {
        $user = $request->user();
       
       
        // Check if the user is already muted
        if ($user->mutes()->where('muted_user_id', $mutedUserId)->exists()) {
            return response()->json(['success' => false, 'message' => 'User is already muted']);
        }
    
        // If not muted, create a new mute
        $mute = Mute::create(['user_id' => $user->id, 'muted_user_id' => $mutedUserId]);
    
        return response()->json(['success' => true, 'message' => 'User muted successfully']);
    }

    public function unmuted(Request $request, $mutedUserId)
    {
        $user = $request->user();
        $mute = Mute::where('user_id', $user->id)->where('muted_user_id', $mutedUserId)->first();

        if ($mute) {
            $mute->delete();
            return response()->json(['success' => true, 'message' => 'User unmuted successfully']);
        }

        return response()->json(['success' => false, 'message' => 'User not found in mute list']);
    }

    public function muteddUsers(Request $request, $mutedUserId)
    {
        //$user = $request->user();
      	$user = User::findOrFail($mutedUserId);
      	//d($user);
        $mutedUsers = $user->mutes()->with('mutedUser')->get();
        $data =  MutedResources::collection($mutedUsers);
        return response()->json([
         'success' => true,
            'data' => $data,
                
            'message' => __('message.success'),
            ], 200);
    }

}
