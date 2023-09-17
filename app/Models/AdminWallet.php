<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminWallet extends Model
{
    use HasFactory;
     
    protected $guarded = [];


    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
