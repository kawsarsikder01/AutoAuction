<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Plan extends Model
{
    use HasFactory;
    protected $table = 'plans';
    protected $fillable = ['plan_name','price','title','expiry_time','expiry_time_type','status','language_id',
                            'currency','currency_symbol','number_of_listing','number_of_images','access_auction','customer_support','promoted_listing',
                            'top_search_result','share_other_platform'
                                    ];
    public $casts = ['services' => 'array'];

    public function user()
    {
        return $this->hasMany(User::class);
        
    }
}
