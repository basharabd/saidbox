<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Store extends User
{
    use HasFactory , HasApiTokens , Notifiable;

    protected $guarded = [];

    public function storeType()
    {
        return $this->belongsTo(StoreType::class);
    }

    public function verificationCodes()
    {
        return $this->hasMany(VerificationCode::class , 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'store_id');
    }
    public function wallets()
    {
        return $this->hasMany(Wallet::class)->orderBy('created_at', 'desc');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }


    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class , 'store_id');
    }


    public function routeNotificationForSms($notification = null)
    {
        return $this->mobile_number;

    }

    public function routeNotificationForFcm($notification = null)
    {
        return $this->deviceTokens()->pluck('token')->toArray();
    }

















}