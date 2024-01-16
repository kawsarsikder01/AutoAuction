<?php

namespace App\Http\Controllers;

use App\Models\BiddingHistory;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\Notify;

class NotifyController extends Controller
{
    use Notify;
    public function index()
    {
        $user = Auth::user();
        $todayDate = Carbon::now()->toDateString();
        $vehicles = Vehicle::with('details', 'biddingHistory')
            ->whereHas('details', function ($query) use ($todayDate) {
                $query->whereDate('auction_ending_date', '<=', $todayDate)->where('sold_status', 0);
            })->get();
        foreach ($vehicles as $vehicle) {
            $maxAmount = $vehicle->biddingHistory->max('bid_amount');
            $soldVehicle = BiddingHistory::where('vehicle_id', $vehicle->id)
                ->where('bid_amount', $maxAmount)
                ->first();// Assuming only one record matches these conditions
            if ($soldVehicle) {
//                dd($soldVehicle);
                $soldVehicle->bidder->update([
                    'balance' => $soldVehicle->bidder->balance - $soldVehicle->bid_amount,
                    'hold_balance' => $soldVehicle->bidder->hold_balance? $soldVehicle->bid_amount + $soldVehicle->bidder->hold_balance: $soldVehicle->bid_amount
                ]);
                $soldVehicle->update([
                    'wining_status' => 1
                ]);
                $soldVehicle->wining_status = 1;
                $soldVehicle->update();
                $vehicle->details->update([
                    'sold_status' => 1,
                    'sold_price' => $maxAmount
                ]);

                $msg = [
                    'vehicle_model' => $soldVehicle->vehicle->details->title,
                ];
                $action = [
                    "link" => '#',
                    "icon" => "fas fa-money-bill-alt text-white"
                ];
                $this->userPushNotification($soldVehicle->bidder, 'WIN_AUCTION', $msg, $action);
                $this->userFirebasePushNotification($soldVehicle->bidder,'WIN_AUCTION', $msg, "#");
                $this->sendMailSms($soldVehicle->bidder, 'WIN_AUCTION', [
                    'username' => $soldVehicle->bidder->firstname." ".$soldVehicle->bidder->lastname,
                    'vehicle_model' => $soldVehicle->vehicle->details->title,
                    'bid_amount' =>$soldVehicle->bid_amount,
                    'auction_ending_date'=> $soldVehicle->vehicle->details->auction_ending_date,
                    'seller_name' => $soldVehicle->vehicle->user->firstname." ".$soldVehicle->vehicle->user->lastname,
                    'contact_number' => $soldVehicle->vehicle->user->phone,
                    'address' => $soldVehicle->vehicle->user->address_one,
                    'company_name' => basicControl()->site_title,
                ]);
                $vehicleOwnerMessage = [
                    'username' => $soldVehicle->vehicle->user->firstname." ".$soldVehicle->vehicle->user->lastname,
                    'vehicle_model' => $soldVehicle->vehicle->details->title,
                    'sale_price' => $soldVehicle->bid_amount,
                    'bidder_name' => $soldVehicle->bidder->firstname." ".$soldVehicle->bidder->lastname,
                    'contact_number' => $soldVehicle->bidder->phone,
                    'company_name' => basicControl()->site_title,
                ];

                $this->userPushNotification($vehicle->user, 'SOLD_VEHICLE', $action);
                $this->userFirebasePushNotification($vehicle->user,'SOLD_VEHICLE', "#");
                $this->sendMailSms($vehicle->user,'SOLD_VEHICLE',$vehicleOwnerMessage);


            }
        }
        return redirect()->route('page')->with('success','Notification Send Successfully');

    }
}
