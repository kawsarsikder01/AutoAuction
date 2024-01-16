<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiddingHistory extends Model
{
    use HasFactory;
    protected  $table = 'bidding_history';
    protected  $fillable = ['user_id','vehicle_id','bid_amount'];
    public  function bidder()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public  function  vehicle()
    {
        return $this->belongsTo(Vehicle::class,'vehicle_id');
    }
}
