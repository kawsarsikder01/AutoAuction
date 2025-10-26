<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Notify;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserKyc;
use App\Models\Plan;
use App\Models\Vehicle;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Notify;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'email',
        'password',
        'referral_id',
        'language_id',
        'email',
        'country_code',
        'country',
        'phone_code',
        'phone',
        'balance',
        'image',
        'image_driver',
        'state',
        'city',
        'zip_code',
        'address_one',
        'address_two',
        'provider',
        'provider_id',
        'status',
        'identity_verify',
        'address_verify',
        'two_fa',
        'two_fa_verify',
        'two_fa_code',
        'email_verification',
        'sms_verification',
        'verify_code',
        'time_zone',
        'sent_at',
        'last_login',
        'last_seen',
        'password',
        'email_verified_at',
        'remember_token',
        'purchased_plan_id',
        'plan_purchase_date',
        'plan_expire_date',
        'total_listed_car',
        'hold_balance',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['last-seen-activity'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'sent_at' => 'date',
    ];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();
        static::saved(function () {
            Cache::forget('userRecord');
        });
    }

    public function funds()
    {
        return $this->hasMany(Fund::class)->latest()->where('status', '!=', 0);
    }
    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class,'user_id');
    }


    public function transaction()
    {
        return $this->hasOne(Transaction::class)->latest();
    }

    public function payout()
    {
        return $this->hasMany(Payout::class, 'user_id');
    }


    public function getLastSeenActivityAttribute()
    {
        if (Cache::has('user-is-online-' . $this->id) == true) {
            return true;
        } else {
            return false;
        }
    }


    public function inAppNotification()
    {
        return $this->morphOne(InAppNotification::class, 'inAppNotificationable', 'in_app_notificationable_type', 'in_app_notificationable_id');
    }

    public function fireBaseToken()
    {
        return $this->morphMany(FireBaseToken::class, 'tokenable');
    }

    public function profilePicture()
    {
        $image = $this->image;
        if (!$image) {
            $active = $this->LastSeenActivity == false ? 'warning' : 'success';
            $firstLetter = substr($this->firstname, 0, 1);
            return '<div class="avatar avatar-sm avatar-soft-primary avatar-circle">
                        <span class="avatar-initials">' . $firstLetter . '</span>
                        <span class="avatar-status avatar-sm-status avatar-status-' . $active . '"></span>
                     </div>';

        } else {
            $url = getFile($this->image_driver, $this->image);
            $active = $this->LastSeenActivity == false ? 'warning' : 'success';
            return '<div class="avatar avatar-sm avatar-circle">
                        <img class="avatar-img" src="' . $url . '" alt="Image Description">
                        <span class="avatar-status avatar-sm-status avatar-status-' . $active . '"></span>
                     </div>';

        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->mail($this, 'PASSWORD_RESET', $params = [
            'message' => '<a href="' . url('password/reset', $token) . '?email=' . $this->email . '" target="_blank">Click To Reset Password</a>'
        ]);
    }
    public function userKyc(){
       return $this->hasMany(UserKyc::class, 'user_id');
    }
    public function plan()
    {
        return $this->belongsTo(PlanPurchaseHistory::class,'purchased_plan_id');

    }
    public function userAllPlans()
    {
        return $this->hasMany(PlanPurchaseHistory::class,'user_id');
    }
    public function vehicle()
    {
        return $this->hasMany(Vehicle::class,'user_id');
    }
    public  function biddingHistory()
    {
        return $this->hasMany(BiddingHistory::class,'user_id');
    }
    public function reporterReport()
    {
        return $this->hasMany(Report::class,'repoter_id');
    }
    public function repotedReport()
    {
        return $this->hasMany(Report::class,'reported_user_id');
    }

    public function notifypermission()
    {
        return $this->morphOne(NotificationPermission::class, 'notifyable');
    }
}
