<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminWallet;
use App\Models\Order;
use App\Models\OrderTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminWallteController extends Controller
{

    public function index(){
        $adminWallet = AdminWallet::all();
        return $adminWallet ;
    }

  




}
