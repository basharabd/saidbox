<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StoreWallet;
use Illuminate\Http\Request;

class StoreWallteController extends Controller
{
    public function index(){
        $storeWallet = StoreWallet::all();
        return $storeWallet ;
    }
}