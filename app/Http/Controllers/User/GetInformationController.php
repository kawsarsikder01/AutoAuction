<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Traits\Notify;
use Illuminate\Support\Facades\Auth;

class GetInformationController extends Controller
{
    use Notify;
    public function getInfo(Request $request)
    {
        $request->validate([
            'fullname' => 'required | string',
            'email' => 'required | email',
            'subject' => 'required | string',
            'comment' => 'required | max:400'
        ]);
        $vehicle = Vehicle::findOrFail($request->vehicle_id);
        if (Auth::user()->id == $vehicle->user->id){
            return back()->with('warning',"You Can Not Send Request");
        }
        $msg = [
            "fullname" => $request->fullname,
            "email" => $request->email,
            "subject" => $request->subject,
            "comment" => $request->comment,
        ];
        $action = [
            "link" => '#',
            "icon" => "fas fa-money-bill-alt text-white"
        ];
        $this->userPushNotification($vehicle->user, 'GET_MORE_INFO', $msg, $action);
        $this->userFirebasePushNotification($vehicle->user,'GET_MORE_INFO', $msg, "#");
        $this->sendMailSms($vehicle->user, 'GET_MORE_INFO', $msg);

        return back()->with('success',"Your Request Send Successfully");
    }
}
