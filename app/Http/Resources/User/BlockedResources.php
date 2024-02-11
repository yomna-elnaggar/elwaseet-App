<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class BlockedResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    { 
        $blockedUser = User::where('id',$this->blocked_user_id)->first();
        return [
            
            'id' => $blockedUser->id,
            'name' => $blockedUser->name,
            'image'=>url('public/'.$blockedUser->image),
            'city'=> $blockedUser->city
            
            ];
    }
}
