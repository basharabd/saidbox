<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CaptainWallet;
use Illuminate\Http\Request;

class CaptainWallteController extends Controller
{
    public function index(){
        $captainWallet = CaptainWallet::all();
        return $captainWallet ;
    }
}