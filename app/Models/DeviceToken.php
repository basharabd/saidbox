<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    use HasFactory;
    protected $fillable = ['store_id', 'admin_id', 'captains_id', 'token', 'device'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function captain()
    {
        return $this->belongsTo(Captain::class);
    }

}
