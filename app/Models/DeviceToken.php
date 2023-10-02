<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    use HasFactory;

    protected $fillable = ['store_id', 'admin_id', 'captain_id', 'token', 'device'];

    public function store()
    {
        return $this->belongsTo(Store::class,'store_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }

    public function captain()
    {
        return $this->belongsTo(Captain::class,'captain_id');
    }



}
