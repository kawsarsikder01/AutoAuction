<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;

class VehicleDetails extends Model
{
    use HasFactory;
    protected $table = 'vehicle_details';
    protected  $guarded = ['id'];

    public  function vehicle()
    {
        return $this->belongsTo(Vehicle::class,'vehicle_id');
    }
}
