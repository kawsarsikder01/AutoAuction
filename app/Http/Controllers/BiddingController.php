<?php

namespace App\Http\Controllers;

use App\Models\BiddingHistory;
use App\Models\Vehicle;
use App\Rules\CheckUserBalance;
use Illuminate\Http\Request;
use App\Rules\CheckBidAmount;
use Illuminate\Support\Facades\Auth;

class BiddingController extends Controller
{

    public function bid(Request $request,$id)
    {


      try {
          $vehicle = Vehicle::findOrFail($id);
          $request->validate([
              'bid_amount' => ['required','numeric', new CheckBidAmount($id,$request->bid_amount),new CheckUserBalance($request->bid_amount,$id)]
          ]);
       $plan = Auth::user()->plan;
        if($vehicle->user_id == Auth::user()->id){
            throw new \Exception('not found');
        }
        if($plan && $plan->access_auction == 0){
          return back()->with('error','You can not access bidding process');
       }
          $bidding = new BiddingHistory();
          $bidding->user_id = Auth::user()->id;
          $bidding->vehicle_id = $id;
          $bidding->bid_amount = $request->bid_amount;
          $bidding->save();
          return back()->with('success','Sucessfully update your bid');
      } catch (\Exception $exception) {
        return view(template(),'errors.404');
      }

    }
}
