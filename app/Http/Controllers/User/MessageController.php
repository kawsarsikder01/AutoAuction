<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index($id)
    {
        
        $messages = Message::where(function ($query) use ($id) {
            $query->where('sender_id', Auth::user()->id)
                ->where('receiver_id', $id);
        })->orWhere(function ($query) use ($id) {
            $query->where('sender_id', $id)
                ->where('receiver_id', Auth::user()->id);
        })->get();
        $user = User::findOrFail($id);
        return view(template().'message',compact('messages','user'));
    }

    public function sendMessage(Request $request)
    {
        $message = new Message();
        $message->sender_id = $request->sender_id;
        $message->receiver_id =  $request->receiver_id;
        $message->message = $request->message;
        $message->save();
        return back();
    }
}
