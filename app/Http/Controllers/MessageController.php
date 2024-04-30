<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'user_id' => $request->user_id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return response()->json(['message' => 'Message sent successfully', 'newmessage' => $message], 201);
    }

    public function getMessages(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id',
        ]);

        $messages = Message::where(function ($query) use ($request) {
            $query->where('user_id', $request->user_id)
                ->where('receiver_id', $request->receiver_id);
        })->orWhere(function ($query) use ($request) {
            $query->where('user_id', $request->receiver_id)
                ->where('receiver_id', $request->user_id);
        })->orderBy('created_at', 'asc')->get();

        return response()->json(['messages' => $messages]);
    }
}
