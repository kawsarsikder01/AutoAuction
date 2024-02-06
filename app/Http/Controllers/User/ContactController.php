<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\Notify;

class ContactController extends Controller
{
    use Notify;
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required | string',
            'email' => 'required | email',
            'subject' => 'required | string',
            'comment' => 'required | max:400'
        ]);
        $msg = [
            "fullname" => $request->fullname,
            "email" => $request->email,
            "subject" => $request->subject,
            "comment" => $request->comment,
        ];
        $action = [
            "link" => '#',
            "icon" => "<i class='bi bi-bell-fill'></i>",
            "image" => getFile(Auth::user()->image_driver, Auth::user()->image)
        ];
        $this->adminPushNotification( 'USER_CONTACT_INFORMATION', $msg, $action);
        $this->adminFirebasePushNotification('USER_CONTACT_INFORMATION', $msg);
        $this->adminMail( 'USER_CONTACT_INFORMATION', $msg);
        return back()->with('success',"Your Request Send Successfully");
    }
}
