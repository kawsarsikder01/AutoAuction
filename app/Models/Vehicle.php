<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VehicleDetails;
use App\Models\User;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = 'vehicle';
    protected $guarded =  ['id'];

    protected $casts = ['path_name' => 'array'];

    public  function  details()
    {
        return $this->hasOne(VehicleDetails::class,'vehicle_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public  function  biddingHistory()
    {
        return $this->hasMany(BiddingHistory::class,'vehicle_id')->orderByDesc('id');
    }
}
