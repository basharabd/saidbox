<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    use HasFactory;

    
 
    protected $guarded = [];

    public function store()
    {
        return $this->belongsTo(Store::class , 'mobile_number');
    }

    public function captain()
    {
        return $this->belongsTo(Captain::class  , 'mobile_number');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class  , 'mobile_number');
    }
}