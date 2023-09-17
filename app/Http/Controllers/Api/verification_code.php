<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VerificationCode;
use Illuminate\Support\Facades\Auth;

class verification_code extends Controller
{

    public function sendVerificationCode()
    
    {
        $code = mt_rand(100000, 999999);

        $data = [
            'code' => $code,
            'user_id' => auth()->user()->id, // Assuming you are using authentication and want to store the code for the currently authenticated user
        ];

        // Delete any existing verification code for the user
        VerificationCode::where('user_id', $data['user_id'])->delete();

        // Create and return the new verification code
        return VerificationCode::create($data);
    }

}