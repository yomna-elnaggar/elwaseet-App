<?php

namespace App\Http\Controllers\Api\Chat;

use App\Events\MessageSent;
use App\Events\MessageDeleted;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Chat\ChatResource;
use App\Http\Resources\Chat\ChatMessageResource;
use App\Http\Resources\Chat\MessageResource;
use App\Notifications\NewMessageNotification;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
  {
      $user = $request->user();
      $received_id = $request->input('received_id');
      $receiver = User::where('id',$received_id)->first();
       $userName= $user->name;
      
      if (!$received_id) {
          return response()->json(['error' => 'received_id is required'], 400);
      }

      $messageText = $request->input('message');

      $message = ChatMessage::create([
          'user_id' => $user->id,
          'received_id' => $received_id,
          'message' => $messageText,
      ]);
      
      if (!$receiver->mutes()->where('muted_user_id', $user->id)->exists() || !$receiver->mutes()->where('muted_user_id', 1)->exists() ) {
         $recipient = User::find($received_id);
      	 $recipient->notify(new NewMessageNotification($messageText,$userName)); 
      }
      
      
      $success['success'] = true;
      $success['chat'] = new MessageResource($message);
      $success['message'] = __('message.success');

      event(new MessageSent(new MessageResource($message)));

      return response()->json($success, 200);
  }
  
    public function sendFile(Request $request)
  {
      $user = $request->user();
      $received_id = $request->input('received_id');
 	  $receiver = User::where('id',$received_id)->first();
      $userName= $user->name;
      if (!$received_id) {
          return response()->json(['error' => 'received_id is required'], 400);
      }

      $messageFile = null;

      if ($request->hasFile('file')) {
          $file = $request->file('file');
          $fileExtension = $file->getClientOriginalExtension();
          $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'txt', 'mp3', 'wav', 'ogg','aac']; 

          if (!in_array($fileExtension, $allowedExtensions)) {
              return response()->json(['error' => 'Invalid file type'], 400);
          }

          $file_name = hexdec(uniqid()) . '.' . $fileExtension;
          $file->move(public_path('upload/chat'), $file_name);
          $save_url = 'upload/chat/' . $file_name;

          $messageFile = $save_url;
      }

      $message = ChatMessage::create([
          'user_id' => $user->id,
          'received_id' => $received_id,
          'file' => $messageFile,
      ]);
      if (!$receiver->mutes()->where('muted_user_id', $user->id)->exists() || !$receiver->mutes()->where('muted_user_id', 1)->exists() ) {
         $recipient = User::find($received_id);
      	 $recipient->notify(new NewMessageNotification('file',$userName)); 
      }

      $success['success'] = true;
      $success['chat'] = new MessageResource($message);
      $success['message'] = __('message.success');

      event(new MessageSent(new MessageResource($message)));

      return response()->json($success, 200);
  }

   public function getUserChats(Request $request)
   {
      $user = $request->user();

          $chats = ChatMessage::where('user_id', $user->id)
        ->orWhere('received_id', $user->id)
        ->selectRaw('DISTINCT IF(user_id = ?, received_id, user_id) as chat_user_id, MAX(created_at) as latest_created_at', [$user->id])
        ->groupBy('chat_user_id') // Add this line to group by chat_user_id
        ->orderBy('latest_created_at', 'desc') // Order by the latest created_at
        ->get();

        $success['success'] = true;
        $success['chats'] = ChatResource::collection($chats);
        $success['message'] = __('message.success');
       return response()->json($success, 200);
   }
   
    public function getUserChatWith(Request $request)
    {
     try {
       	 $perPage = $request->input('perPage', 10);
         $user = $request->user();
         $received_id = $request->input('received_id');
         if (!$received_id) {
             return response()->json(['error' => 'received_id is required'], 400);
         }
    
         $receivedUser = User::findOrFail($received_id);
       
      	 ChatMessage::where('user_id', $receivedUser->id)
         ->where('received_id', $user->id)
         ->where('status', 0)
         ->update(['status' => 1]);
      
    
         $chats = ChatMessage::where(function ($query) use ($user, $receivedUser) {
                 $query->where('user_id', $user->id)
                     ->where('received_id', $receivedUser->id);
             })
             ->orWhere(function ($query) use ($user, $receivedUser) {
                 $query->where('received_id', $user->id)
                     ->where('user_id', $receivedUser->id);
             })->orderBy('id','desc')->paginate($perPage);
       
       	
           $data= MessageResource::collection($chats);
    
           return response()->json([
            'success' => true,
            'data' => $data,
                'pagination' => [
                    'current_page' => $data->currentPage(),
                    'last_page' => $data->lastPage(),
                    'per_page' => $data->perPage(),
                    'total' => $data->total(),
                ],
            'message' => __('message.success'),
            ], 200);
    
         return response()->json($success, 200);
     } catch (ModelNotFoundException $e) {
         return response()->json(['error' => 'User not found'], 404);
     } catch (\Exception $e) {
         // Handle other exceptions if needed
         return response()->json(['error' => 'Internal Server Error'], 500);
     }
    }
   
    public function deleteMessage(Request $request)
    {
        $user = $request->user();
        $message = ChatMessage::find($request->message_id);
        if (!$message) {
            return response()->json(['error' => 'Message not found'], 404);
        }
    
        if ($user->id !== $message->user_id) {
            return response()->json(['error' => 'You do not have permission to delete this message.'], 403);
        }
      	
        if ($message->file) {
          if (file_exists($message->file)) {
            unlink('public/'.$message->file);
          }
        }
        $message->delete();
    
      
        return response()->json(['message' => 'Message deleted successfully']);
        
    }
    
    public function deleteChat(Request $request)
    {
        $user = $request->user();
        $received_id = $request->input('received_id');

        // Delete all messages sent by the authenticated user to the specified receiver
        ChatMessage::where('user_id', $user->id)
            ->where('received_id', $received_id)
            ->delete();

        // Delete all messages received by the authenticated user from the specified sender
        ChatMessage::where('user_id', $received_id)
            ->where('received_id', $user->id)
            ->delete();

        return response()->json(['message' => 'Chat deleted successfully']);
    }
    
    

}
