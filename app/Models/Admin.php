<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Admin extends Model
{
    use HasFactory , HasApiTokens , Notifiable ;

    protected $guarded = [];

    public function verificationCodes()
    {
        return $this->hasMany(VerificationCode::class , 'id');
    }

    public function wallet()
    {
        return $this->hasOne(AdminWallet::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }


    public function routeNotificationForSms($notification = null)
    {
        return $this->mobile_number;

    }

    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class, 'admin_id');
    }


}
