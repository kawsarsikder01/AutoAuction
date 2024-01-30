<?php

namespace App\Rules;

use App\Models\BiddingHistory;
use App\Models\Vehicle;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class CheckUserBalance implements ValidationRule
{
    protected $bid_amount;
    protected $vehicle_id;
    public function __construct($request_bid,$vehicle_id)
    {
        $this->bid_amount = $request_bid;
        $this->vehicle_id = $vehicle_id;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = Auth::user();
        $biddingHistorys =BiddingHistory::whereIn('bid_amount', function ($query) {
            $query->selectRaw('MAX(bid_amount)')
                ->from('bidding_history')
                ->groupBy('vehicle_id');
          })->with('vehicle')->where('user_id',$user->id)->where('wining_status',0)->get();
        $totalBidAmount = $this->bid_amount;
          foreach($biddingHistorys as $biddingHistory){
              if ($biddingHistory->vehicle->biddingHistory->max('bid_amount') != $biddingHistory->bid_amount){
                  continue;
              }
              $totalBidAmount = $totalBidAmount + $biddingHistory->bid_amount;
              if ($biddingHistory->vehicle->biddingHistory->max('bid_amount') == $biddingHistory->bid_amount){
                  if($this->vehicle_id == $biddingHistory->vehicle_id){
                      $totalBidAmount = $totalBidAmount - $biddingHistory->bid_amount;
                  }
              }
          }
        if ($biddingHistorys->first() && $totalBidAmount -$this->bid_amount > 0){
            if($totalBidAmount  > $user->balance){
                $totalBidAmount = $totalBidAmount-$this->bid_amount;
                $fail("Your balance is low because your $totalBidAmount ".basicControl()->currency_symbol." is hold");
            }
        }
        if($user->balance < $this->bid_amount){
            $fail("Your balance is low please deposit your account");
        }
    }
}
