<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaptainWallet extends Model
{
    use HasFactory;

    public function captain()
    {
        return $this->belongsTo(Captain::class);
    }
}