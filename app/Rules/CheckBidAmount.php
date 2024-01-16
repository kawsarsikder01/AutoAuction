<?php

namespace App\Rules;

use App\Models\Vehicle;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckBidAmount implements ValidationRule
{
    protected $id;
    protected $bid_amount;
    public function __construct($id,$bid_amount)
    {
        $this->id = $id;
        $this->bid_amount = $bid_amount;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $vehicle = Vehicle::find($this->id);
        $max_bid = $vehicle->biddingHistory->max('bid_amount');
        if($max_bid != null){
            if($max_bid >= $this->bid_amount){
                $minimum_bid = $max_bid + 1;
                $fail("Minimum Bid Amount $minimum_bid ".basicControl()->currency_symbol."");
            }
        }else{
            $minimum_bid = $vehicle->details->price;
            if($vehicle->details->price > $this->bid_amount){
                $fail("Minimum Bid Amount $minimum_bid ".basicControl()->currency_symbol."");
            }
        }
    }
}
