<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required | string',
            'email' => 'required | email',
            'subject' => 'required | string',
            'comment' => 'required | max:400'
        ]);
        $contact = new Contact();
        $contact->fullname = $request->fullname;
        $contact->email = $request->email;
        $contact->subject = $request->subject;
        $contact->comment = $request->comment;
        $contact->save();
        return back()->with('success',"Your Request Send Successfully");
    }
}
