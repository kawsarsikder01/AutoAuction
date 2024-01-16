<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['transactional_id', 'transactional_type', 'user_id', 'amount', 'balance', 'charge', 'trx_type', 'remarks', 'trx_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function transactional()
    {
        return $this->morphTo();
    }

}
