<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeviceToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceTokenController extends Controller
{
    public function store(Request $request)
    {
        // Store the FCM token in your device_tokens table
        DeviceToken::create([
            'store_id' => $request->input('store_id'),
            'token' => $request->input('token'),
            'device' => $request->input('device'),
        ]);

        return response()->json(['message' => 'Token stored successfully']);
    }
}
