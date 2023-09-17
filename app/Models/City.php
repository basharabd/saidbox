<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function Rang()
    {
        return $this->hasMany(Rang::class, 'city_id');
    }

    public function captains()
    {
        return $this->hasMany(Captain::class);
    }

    public function admins()
    {
        return $this->hasMany(Admin::class);
    }










}