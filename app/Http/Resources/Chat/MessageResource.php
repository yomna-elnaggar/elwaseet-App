<?php

namespace App\Http\Resources\Chat;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

         $sender = User::select('id','name','image')->where('id',$this->user_id)->first();
         $resiver = User::select('id','name','image')->where('id',$this->received_id)->first();
        return [
            'id'=>$this->id,
            'message'=>$this->message,
          	'file'=>$this->file?url('public/'.$this->file):null,
            'created_at'=>$this->created_at,
          	'status' =>$this->status,
            'sender id'=>$sender->id,
            'sender name'=>$sender->name,
            'sender image'=>url('public/'.$sender->image),
            'resiver id'=>$resiver->id,
            'resiver name'=>$resiver->name,
            'resiver image'=>url('public/'.$resiver->image),
          
            ];
    }
}
