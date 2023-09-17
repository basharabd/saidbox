<?php

namespace App\Models;

use App\Notifications\NewOrderNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use HasFactory , Notifiable;

    protected $guarded = [];

    public function store()
    {
        return $this->belongsTo(Store::class , 'store_id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function orderTransaction()
    {
        return $this->hasOne(OrderTransaction::class);
    }

    public function captain()
    {
        return $this->belongsTo(Captain::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function reason()
    {
        return $this->belongsTo(Reason::class);
    }



    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    protected static function booted()
    {
        static::created(function ($order) {
            $store = $order->store;

            $store->notify(new NewOrderNotification($order));
        });
    }



}
