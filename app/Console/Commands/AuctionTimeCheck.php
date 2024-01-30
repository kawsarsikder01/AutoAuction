<?php

namespace App\Console\Commands;

use App\Models\BiddingHistory;
use App\Models\Vehicle;
use App\Models\VehicleDetails;
use App\Traits\Notify;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AuctionTimeCheck extends Command
{
    use Notify;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auction-time-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $todayDate = Carbon::now()->toDateString();
        $vehicles = Vehicle::with('details', 'biddingHistory')
            ->whereHas('details', function ($query) use ($todayDate) {
                $query->whereDate('auction_ending_date', '<=', $todayDate)->where('is_send_notification',0)->where('sold_status',0);
            })->get();
        if (count($vehicles) > 0){
            foreach ($vehicles as $vehicle) {
                try {
                    $maxAmount = $vehicle->biddingHistory->max('bid_amount');
                    $soldVehicle = BiddingHistory::where('vehicle_id', $vehicle->id)
                        ->where('bid_amount', $maxAmount)
                        ->first();
                    if ($soldVehicle) {
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
                            'sold_price' => $maxAmount,
                            'is_send_notification' => 1
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

                        $this->userPushNotification($vehicle->user, 'SOLD_VEHICLE',$vehicleOwnerMessage, $action);
                        $this->userFirebasePushNotification($vehicle->user,'SOLD_VEHICLE',$vehicleOwnerMessage, "#");
                        $this->sendMailSms($vehicle->user,'SOLD_VEHICLE',$vehicleOwnerMessage);


                    }
                }catch (\Exception $e){
                    continue;
                }
            }
        }
    }
}
