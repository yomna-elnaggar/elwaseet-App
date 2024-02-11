<?php

namespace App\Http\Resources\Chat;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $sender = User::select('name','image')->where('id',$this->user_id)->first();
        
        return [
            'id'=>$this->id,
            'message'=>$this->message,
            'created_at'=>$this->created_at,
            'sender name'=>$sender->name,
            'sender image'=>url('public/'.$sender->image)
            
            
            ];
    }
}
