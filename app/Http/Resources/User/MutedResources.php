<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class MutedResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    { 
        $mutedUser = User::where('id',$this->muted_user_id)->first();
        return [
            
            'id' => $mutedUser->id,
            'name' => $mutedUser->name,
            'image'=>url('public/'.$mutedUser->image),
           
            
            ];
    }
}
