<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarBrand extends Model
{
    protected  $table = 'auction_car_brand';
    protected  $guarded = ['id'];
    use HasFactory;
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class,'brand_id');
    }
}
