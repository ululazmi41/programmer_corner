<?php

namespace App\Http\Controllers;

use App\Models\Chat\Conversation;
use App\Models\Chat\Message;
use App\Models\Chat\Participant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());
        $chatrooms = [];

        foreach ($user->corners as $corner) {
            // later: skip if already a member on group chat

            $lastMessage = $corner->conversation->lastMessage;

            if ($lastMessage) {
                $sender = User::find($lastMessage->user_id);
            }

            $data = [
                'id' => $corner->conversation->id,
                'name' => $corner->name,
                'type' => 'group',
                'image_url' => $corner->icon_url,
                'conversation_id' => $corner->conversation->id,
                'last_message_content' => $lastMessage ? $lastMessage->content : null,
                'last_message_user_id' => $lastMessage ? $sender->id : null,
                'last_message_user_name' => $lastMessage ? $sender->name : null,
                'last_message_timestamp' => $lastMessage ? $lastMessage->updated_at : null,
            ];
            array_push($chatrooms, $data);
        }

        foreach ($chatrooms as $room) {
            if ($room['last_message_timestamp'] == null) {
                $room['last_message_timestamp'] = PHP_INT_MIN;
            }
        }

        usort($chatrooms, function ($a, $b) {
            return $a['last_message_timestamp'] <=> $b['last_message_timestamp'];
        });

        return view('chat', compact('chatrooms'));
    }

    public function fetch(String $id)
    {
        $conversation = Conversation::find($id);
        $messages = Message::with('user')->where('conversation_id', $conversation->id)->get();
        $participants = Participant::where(['conversation_id', $conversation->id]);

        return response()->json([
            'id' => $conversation->id,
            'type' => $conversation->type,
            'messages' => $messages,
            'participants' => $participants,
        ]);
    }
}
