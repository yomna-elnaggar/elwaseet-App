<?php

namespace App\Http\Controllers\Api\Block;

use App\Models\Block;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\BlockedResources;

class BlockController extends Controller
{
    public function blockUser(Request $request, $blockedUserId)
    {
        $user = $request->user();
        // Check if the user is already blocked
        if ($user->blocks()->where('blocked_user_id', $blockedUserId)->exists()) {
            return response()->json(['success' => false, 'message' => 'User is already blocked']);
        }
    
        // If not blocked, create a new block
        $block = Block::create(['user_id' => $user->id, 'blocked_user_id' => $blockedUserId]);
    
        return response()->json(['success' => true, 'message' => 'User blocked successfully']);
    }

    public function unblockUser(Request $request, $blockedUserId)
    {
        $user = $request->user();
        $block = Block::where('user_id', $user->id)->where('blocked_user_id', $blockedUserId)->first();

        if ($block) {
            $block->delete();
            return response()->json(['success' => true, 'message' => 'User unblocked successfully']);
        }

        return response()->json(['success' => false, 'message' => 'User not found in blocked list']);
    }

    public function blockedUsers(Request $request)
    {
        $user = $request->user();
        $blockedUsers = $user->blocks()->with('blockedUser')->get();
        $data =  BlockedResources::collection($blockedUsers);
        return response()->json([
         'success' => true,
            'data' => $data,
                
            'message' => __('message.success'),
            ], 200);
    }

}
