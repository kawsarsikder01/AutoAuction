<?php

namespace App\Http\Controllers;

use App\Models\BiddingHistory;
use App\Models\CarBrand;
use App\Models\CarCategory;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\Notify;
class BidderController extends Controller
{
    use Notify;
    public function viewAuctionDetails($slug = 'your-property-name',$id)
    {
        $vehicle = Vehicle::with('details','user')->find($id);
        if(($vehicle->status == 0 || $vehicle->status == 2) && $vehicle->user_id != Auth::user()->id){
            return abort(404);
        }
        $maxBidAmount = $vehicle->biddingHistory->max('bid_amount');
        $maxBid = BiddingHistory::with('vehicle')
            ->where('vehicle_id',$id)
            ->where('bid_amount',$maxBidAmount)->first();

        return view(template().'auctionDetails',compact('vehicle','maxBid'));
    }

    public function UserBiddingHistory()
    {
        $user = Auth::user();
        $data['categories'] =  CarCategory::get();
        $data['brands'] =  CarBrand::get();
        $biddingHistorys =BiddingHistory::with('vehicle')->where('user_id',$user->id)->orderBy('created_at', 'DESC')->paginate(basicControl()->paginate);
        return view(template().'biddingHistory',compact('biddingHistorys'),$data);
    }

    public  function payNow(Request $request)
    {
        $vehicle = Vehicle::where('payment_status',0)->find($request->vehicle_id);
        if ($vehicle){
            $vehicle->payment_status = 1;
            $vehicle->update();
            $maxAmount = $vehicle->biddingHistory->max('bid_amount');
            $soldVehicle = BiddingHistory::where('vehicle_id', $vehicle->id)
                ->where('bid_amount', $maxAmount)
                ->first();
            if ($soldVehicle && $soldVehicle->user_id == Auth::user()->id){
                $soldVehicle->bidder->hold_balance =  $soldVehicle->bidder->hold_balance - $maxAmount;
                $vehicle->user->balance = $vehicle->user->balance + $maxAmount;
                $soldVehicle->bidder->update();
                $vehicle->user->update();


                $msg1 = [
                    'seller_name' => $vehicle->user->firstname." ". $vehicle->user->lastname,
                    'bidder_name' => $soldVehicle->bidder->firstname." ".$soldVehicle->bidder->lastname,
                    'vehicle_name' => $soldVehicle->vehicle->details->title,
                    'bid_amount' => $soldVehicle->bid_amount,
                    'delivery_status' => $vehicle->release_status==1?'Delivered':'Not Delivered',
                    'transaction_status' => $vehicle->payment_status==1?'Complete':'Uncompleted',
                    'current_balance' => $vehicle->user->balance,
                ];
                $msg2 = [
                    'seller_name' => $vehicle->user->firstname." ". $vehicle->user->lastname,
                    'bidder_name' => $soldVehicle->bidder->firstname." ".$soldVehicle->bidder->lastname,
                    'vehicle_name' => $soldVehicle->vehicle->details->title,
                    'bid_amount' => $soldVehicle->bid_amount,
                    'delivery_status' => $vehicle->release_status==1?'Delivered':'Not Delivered',
                    'transaction_status' => $vehicle->payment_status==1?'Complete':'Uncompleted',
                    'current_balance' => $soldVehicle->bidder->balance,
                ];

                $action = [
                    "link" => '#',
                    "icon" => "fas fa-money-bill-alt text-white"
                ];
                //seller notify
                $this->userPushNotification($vehicle->user, 'SELLER_PAYMENT_CONFIRMATION',$msg1, $action);
                $this->userFirebasePushNotification($vehicle->user,'SELLER_PAYMENT_CONFIRMATION',$msg1, "#",);
                $this->sendMailSms($vehicle->user,'SELLER_PAYMENT_CONFIRMATION',$msg1);
                //bidder notify
                $this->userPushNotification($soldVehicle->bidder, 'BIDDER_PAYMENT_CONFIRMATION',$msg2, $action);
                $this->userFirebasePushNotification($soldVehicle->bidder,'BIDDER_PAYMENT_CONFIRMATION',$msg2, "#",);
                $this->sendMailSms($soldVehicle->bidder,'BIDDER_PAYMENT_CONFIRMATION',$msg2);
            }
        }else{
            return back(404);
        }
        return back()->with('success','Your Payment Successfully Completed');
    }

}
