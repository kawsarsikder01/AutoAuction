<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BiddingHistory;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index($id,$bid_id)
    {
    

        try {
            $bid = BiddingHistory::where('wining_status',1)->findOrFail($bid_id);
            if ($bid->vehicle->user_id != Auth::user()->id){
                abort(404);
            }
            $vehicleMaxBid = BiddingHistory::where('vehicle_id',$bid->vehicle_id)
            ->where('wining_status',1)->first();
            if ($vehicleMaxBid->user_id != $id){
               abort(404);
            }
            $user = User::findOrFail($id);
            $messages = Message::where(function ($query) use ($id) {
                $query->where('sender_id', Auth::user()->id)
                    ->where('receiver_id', $id);
            })->orWhere(function ($query) use ($id) {
                $query->where('sender_id', $id)
                    ->where('receiver_id', Auth::user()->id);
            })->get();

            if ($messages->first() && ($messages->first()->sender_id !=  Auth::user()->id && $messages->first()->receiver_id != Auth::user()->id)){
                abort(404);
            }
            return view(template().'user.pages.message',compact('messages','user'));
        }catch (\Exception $exception){
            return abort(404);
        }
    }
    public function showMessagesForBidder($id,$bid_id)
    {
        try {
            $bid = BiddingHistory::where('wining_status',1)->findOrFail($bid_id);
            
            if ($bid->user_id != Auth::user()->id){
                abort(404);
            }
            if ($bid->vehicle->user_id != $id){
                abort(404);
            }
            $user = User::findOrFail($id);
            $messages = Message::where(function ($query) use ($id) {
                $query->where('sender_id', Auth::user()->id)
                    ->where('receiver_id', $id);
            })->orWhere(function ($query) use ($id) {
                $query->where('sender_id', $id)
                    ->where('receiver_id', Auth::user()->id);
            })->get();

            if ($messages->first() && ($messages->first()->sender_id !=  Auth::user()->id && $messages->first()->receiver_id != Auth::user()->id)){
                abort(404);
            }
            return view(template().'user.pages.message',compact('messages','user'));
        }catch (\Exception $exception){
            abort(404);
        }
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
