<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryManLocation extends Model
{
    use HasFactory;
    protected $table = 'delivery_man_locations';
    protected $fillable=['current_location' , 'captain_id'];
}
