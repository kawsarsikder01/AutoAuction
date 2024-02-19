<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanPurchaseHistory extends Model
{
    use HasFactory;
    protected $table = 'plan_purchase_history';
    protected $guarded = ['id'];


    public function user()
    {
        return $this->hasOne(User::class,'purchased_plan_id');
    }
    public function vehicle()
    {
        return $this->hasMany(Vehicle::class,'user_current_plan_id');
    }
}
