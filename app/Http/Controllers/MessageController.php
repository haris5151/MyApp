<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

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
            'appointment_id'=>$request->appointment_id
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
        })->orderBy('created_at', 'asc')
        ->with(['sender', 'receiver'])
        ->get();

        return response()->json(['messages' => $messages]);
    }
    // public function getMessages(Request $request)
    // {
    //     $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //         'receiver_id' => 'required|exists:users,id',
    //     ]);
    
    //     $user_id = $request->user_id;
    //     $receiver_id = $request->receiver_id;
    
    //     $messages = Message::where(function ($query) use ($user_id, $receiver_id) {
    //         $query->where('user_id', $user_id)
    //             ->where('receiver_id', $receiver_id);
    //     })->orWhere(function ($query) use ($user_id, $receiver_id) {
    //         $query->where('user_id', $receiver_id)
    //             ->where('receiver_id', $user_id);
    //     })->orderBy('created_at', 'asc')
    //     ->with(['user', 'receiver'])
    //     ->get();
    
    //     return response()->json(['messages' => $messages]);
    // }
}
