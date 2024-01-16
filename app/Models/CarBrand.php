<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarBrand extends Model
{
    protected  $table = 'auction_car_brand';
    protected  $guarded = ['id'];
    use HasFactory;
}
