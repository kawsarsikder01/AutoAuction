<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        return view(template().'auth.passwords.email');
    }
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );
        return $response == Password::RESET_LINK_SENT
        ? $this->sendResetLinkResponse($request,$response)
        :$this->sendResetLinkFailedResponse($request,$response);
    }
    public function sendResetLinkFailedResponse(Request $request,$response)
    {
        if ($request->wantsJson()) {
            throw ValidationException::withMessages([
                'email' => [trans($response)],
            ]);
        }


        if($request->ajax()) {
            return response()->json(['errors'=>['email'=>trans($response)]],422);
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }
    public function sendResetLinkResponse(Request $request,$response)
    {
        if($request->ajax()){
           return response()->josn([
            'status' => 200,
            'message'=> trans($response)
           ]);
        }
    return $request->wantsJson()
     ? new JsonResponse(['message' => trans($response)], 200)
     : back()->with('status', trans($response));
    
    }
    public function broker()
    {
       return Password::broker();
    }

}
