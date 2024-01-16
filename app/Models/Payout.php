<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Payout extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'payout_method_id', 'payout_currency_code', 'amount', 'charge', 'net_amount', 'amount_in_base_currency',
    'charge_in_base_currency', 'net_amount_in_base_currency', 'response_id', 'last_error', 'information', 'meta_field', 'feedback', 'trx_id', 'status'];

    protected $table = 'payouts';

    protected $casts = [
        'information' => 'object',
        'meta_field' => 'object',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function method()
    {
        return $this->belongsTo(PayoutMethod::class, 'payout_method_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::saved(function () {
            Cache::forget('payoutRecord');
        });
    }

    public function getStatusClass()
    {
        return [
            '1' => 'text-pending',
            '2' => 'text-success',
            '3' => 'text-danger',
        ][$this->status] ?? 'text-success';
    }

    public function payoutMethod()
    {
        return $this->belongsTo(PayoutMethod::class, 'payout_method_id', 'id');
    }

    public function transactional()
    {
        return $this->morphOne(Transaction::class, 'transactional');
    }

    public function picture()
    {
        $image = $this->method->image;
        if (!$image) {
            $url = getFile($this->method->driver, $this->method->logo);
            return '<div class="avatar avatar-sm avatar-circle">
                        <img class="avatar-img" src="' . $url . '" alt="Image Description">
                     </div>';

        } else {
            $firstLetter = substr($this->method->name, 0, 1);
            return '<div class="avatar avatar-sm avatar-soft-primary avatar-circle">
                        <span class="avatar-initials">' . $firstLetter . '</span>
                     </div>';
        }
    }

}
