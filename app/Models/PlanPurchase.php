<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Plan;

class PlanPurchase extends Model
{
    use HasFactory;

    protected $table = 'plan_purchase';
    protected $fillable = [
        'user_id',
        'plan_id'
    ];
    
}
