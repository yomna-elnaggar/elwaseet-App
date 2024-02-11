<?php

namespace App\Http\Resources\Chat;

use App\Models\User;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray($request)
    {
        $receiver = User::find($this->chat_user_id);

        if ($receiver) {
            $lastMessage = ChatMessage::where(function ($query) use ($receiver, $request) {
                $query->where('user_id', $request->user()->id)
                    ->where('received_id', $receiver->id);
            })->orWhere(function ($query) use ($receiver, $request) {
                $query->where('user_id', $receiver->id)
                    ->where('received_id', $request->user()->id);
            })->orderBy('created_at', 'desc')->first();
          
			
            return [
                'id' => $this->chat_user_id,
                'receiver name' => $receiver->name,
                'receiver image' => url('public/' . $receiver->image),
                'last_message' => $lastMessage ? $lastMessage->message : null,
                'last_message_type' => $lastMessage ? $lastMessage->file ? 'image' : 'text' : null,
                'last_message_created_at' => $lastMessage ? $lastMessage->created_at : null,
              	'last_message_status' => $lastMessage ? $lastMessage->status : null,
              	'last_message_recev_id'=>$lastMessage ? $lastMessage->received_id : null,
            ];
        }

        return ["not found"];
    }
}
