<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserKyc;

class Kyc extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'input_form', 'status','type'];

    public $casts = ['input_form' => 'object'];

    public function user_kyc(){
        return $this->hasMany(UserKyc::class, 'kyc_id');
    }

}
