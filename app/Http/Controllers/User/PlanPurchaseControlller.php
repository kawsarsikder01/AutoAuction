<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Plan;

class PlanPurchaseControlller extends Controller
{
    public  function purchasePlan ($id)
    {
      $plan = Plan::find($id);
      if(Auth::user()->plan && $plan->price < Auth::user()->plan->price){
        return back()->with('warning',"You Can Not Downgrade Your Plan");
      }
        if(Auth::user()->plan){
            return  abort(404);
        }

       $user =  Auth::user();
        if($user->plan_id == $id){
            return abort(404);
          }else{
            $user->plan_id = $id;
            $user->plan_purchase_date = Carbon::now()->toDateTimeString();
            if ($plan->expiry_time_type == 'days' || $plan->expiry_time_type == 'day') {
                $user->plan_expire_date = Carbon::now()->addDays($plan->expiry_time);
            } elseif ($plan->expiry_time_type == 'months' || $plan->expiry_time_type == 'month') {
                $user->plan_expire_date = Carbon::now()->addMonths($plan->expiry_time);
            } elseif ($plan->expiry_time_type == 'years' || $plan->expiry_time_type == 'year') {
                $user->plan_expire_date = Carbon::now()->addYears($plan->expiry_time);
            } else {
                $user->expire_date = null;
            }
            $user->update();

          }
       return back()->with('success', 'Your plan purchase has been successfully completed');
    }
    public  function upgradePlan($id)
    {
        $user = Auth::user();
        if ($user->total_listed_car > 0){
            $user->total_listed_car = 0;
            $user->update();
        }
        if(!$user->plan){
            return abort(404);
        }
        $plan = Plan::find($id);
        $user->plan_id = $id;
        $user->plan_purchase_date = Carbon::now()->toDateTimeString();
        if ($plan->expiry_time_type == 'days' || $plan->expiry_time_type == 'day') {
            $user->plan_expire_date = Carbon::now()->addDays($plan->expiry_time);
        } elseif ($plan->expiry_time_type == 'months' || $plan->expiry_time_type == 'month') {
            $user->plan_expire_date = Carbon::now()->addMonths($plan->expiry_time);
        } elseif ($plan->expiry_time_type == 'years' || $plan->expiry_time_type == 'year') {
            $user->plan_expire_date = Carbon::now()->addYears($plan->expiry_time);
        } else {
            $user->expire_date = null;
        }
        $user->update();
        return  back()->with("success","Plan Update Successfully");
    }
}
