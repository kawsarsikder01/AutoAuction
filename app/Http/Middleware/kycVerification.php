<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserKyc;
use App\Models\Kyc;
use Illuminate\Support\Facades\Auth;

class kycVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

     $user = Auth::user();

//       $kyc = Kyc::get();
//       foreach($kyc as $item){
//          $validateForm =  UserKyc::where('user_id', $user->id)->where('kyc_type',$item->name)->get();
//           if(!$validateForm->first()){
//               return redirect()->route('user.profile')->with(['warning'=>'You are not submitted '.$item->name.' form','kycForm' => $item->name]);
//           }else{
//
//               $check = checkKycForm($validateForm);
//               if (isset($check['is_pending'])){
//                   return back()->with('warning',"Your ". $check['is_pending']." is pending");
//               }elseif (isset($check['rejected'])){
//                   return back()->with('warning',"Your ". $check['rejected']." form has been rejected");
//               }
//           }
//       }
        return $next($request);
    }
}
