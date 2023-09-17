<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rang extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function toCity()
    {
        return $this->belongsTo(City::class, 'to_city_id');
    }



}