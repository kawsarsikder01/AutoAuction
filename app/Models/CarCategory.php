<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarCategory extends Model
{
    protected  $table = 'auction_car_category';
    protected  $guarded = ['id'];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class,'category_id');
    }
    use HasFactory;
}
