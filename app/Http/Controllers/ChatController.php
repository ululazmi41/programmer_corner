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
                'handle' => $corner->handle,
                'type' => 'group',
                'image_url' => $corner->icon_url,
                'conversation_id' => $corner->conversation->id,
                'last_message_content' => $lastMessage ? $lastMessage->content : null,
                'last_message_user_id' => $lastMessage ? $sender->id ?? null : null,
                'last_message_user_name' => $lastMessage ? $sender->name ?? null : null,
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
            return $b['last_message_timestamp'] <=> $a['last_message_timestamp'];
        });

        return view('chat', compact('chatrooms'));
    }

    public function join(Request $request)
    {
        $request->validate([
            'userId' => 'required',
            'conversationId' => 'required',
        ]);

        $user = User::find($request->userId);
        $conversation = Conversation::find($request->conversationId);

        $alreadyParticipated = Participant::where('user_id', $user->id)->where('conversation_id', $conversation->id)->exists();

        if ($alreadyParticipated) {
            return response()->json([
                'status' => 'ok',
                'message' => 'already joined',
            ]);
        }

        $participant = Participant::create([
            'user_id' => $user->id,
            'conversation_id' => $conversation->id,
        ]);

        Message::create([
            'user_id' => null,
            'conversation_id' => $conversation->id,
            'content' => 'user_joined',
            'is_system' => true,
            'target_user_id' => Auth::id(),
        ]);

        return response()->json([
            'status' => 'ok',
            'userId' => $user->id,
            'participantId' => $participant->id,
            'conversationId' => $conversation->id,
        ], 201);
    }

    public function fetch(String $id)
    {
        $conversation = Conversation::find($id);
        $messages = Message::with(['user', 'targetUser'])->where('conversation_id', $conversation->id)->get();
        $participants = Participant::where('conversation_id', $conversation->id);
        $isMember = Participant::where('conversation_id', $conversation->id)
                        ->where('user_id', Auth::id())
                        ->exists();

        return response()->json([
            'is_member' => $isMember,
            'id' => $conversation->id,
            'type' => $conversation->type,
            'messages' => $messages,
            'participants' => $participants,
        ]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'userId' => 'required',
            'conversationId' => 'required',
        ]);

        $message = Message::create([
            'content' => $request->content,
            'user_id' => $request->userId,
            'conversation_id' => $request->conversationId,
        ]);

        return response()->json([
            'status' => 'ok',
            'message_id' => $message->id,
        ]);
    }

    public function leave(Request $request)
    {
        $request->validate([
            'userId' => 'required',
            'conversationId' => 'required',
        ]);

        $participant = Participant::where('user_id', $request->userId)->where('conversation_id', $request->conversationId)->firstOrFail();
        $participant->delete();

        Message::create([
            'user_id' => null,
            'conversation_id' => $request->conversationId,
            'content' => 'user_left',
            'is_system' => true,
            'target_user_id' => Auth::id(),
        ]);

        return response()->json([
            'status' => 'ok',
        ]);
    }
}
