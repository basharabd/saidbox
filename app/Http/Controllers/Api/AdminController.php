<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\GatewaySms;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\Captain;
use App\Models\Store;
use App\Models\VerificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;


class AdminController extends Controller
{

//    public $smsService;
//    public function __construct(GatewaySms $smsService)
//    {
//
//        $this->smsService = $smsService;
//
//    }



    public function login(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|string|max:10',
        ]);

        $phone = $request->input('mobile_number');
        $admin = Admin::where('mobile_number', $phone)->first();

        if ($admin) {
            $code = mt_rand(10000, 99999);
            VerificationCode::create([
                'phone' => $phone,
                'code' => $code,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'send Code successfully',
            ],200);

        } else {
            return response()->json([
                'status' => false,
                'message' => 'Mobile number is not registered. Please proceed with registration.',
            ] , 404);
        }
    }

    public function signup (Request $request)
    {
        $request->validate([
            'admin_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:10|unique:admins,mobile_number',
            'date_of_birth' => 'required|date',
            'id_number' => 'required|string|max:255',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'integer',
            'city_id' => 'required|exists:cities,id',
        ]);

        try {
            DB::beginTransaction();
            $mob = $request->mobile_number;
            $admin = new Admin($request->all());
            $admin->save();
            $user_secret = new VerificationCode([
                'phone'=>$request->mobile_number,
                'code'=> mt_rand(10000, 99999),
            ]);

            $admin->verificationCodes()->save($user_secret);

            DB::commit();

            return response()->json([
                'status'=>true,
                'message' => 'Admin Created successfully',
                'code' => 'Send Code successfully',

            ] , 201);
        } catch (\Exception $e) {
            DB::rollBack();
            // Handle the exception
            return response()->json([
                'status' => false,
                'error' => 'An error occurred while creating admin',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function verify(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'code' => 'required',
        ]);

        $phone = $request->phone;
        $code = $request->code;
        $admin = Admin::where('mobile_number', $phone)->first();
        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'No Admin found with this phone number.',
            ], 404);
        }

        $verificationCode = VerificationCode::where('phone', $phone)->first();

        if (!$verificationCode || $verificationCode->code != $code) {
            return response()->json([
                'success' => false,
                'message' => 'Verification code does not match.',
            ], 400);
        } else {
            $admin->update([
                'phone_verified_at' => Carbon::now(),
            ]);

            $verificationCode->delete();
            $token = $admin->createToken('Personal Access Token')->plainTextToken;


            return response()->json([
                'success' => true,
                'message' => 'Login successfully.',
                'data'=>$admin,
                'token'=>$token,
            ], 200);
        }
    }
    public function resendCode(Request $request)
    {

        $mobile_number = $request->mobile_number;

        $admin = Admin::where('mobile_number', $mobile_number)->first();

        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'No Admin found with this phone number.',
            ], 404);
        }

        $verificationCode = VerificationCode::updateOrCreate(

            ['phone'=>$request->mobile_number],

            ['code' => rand(10000, 99999)],
        );

        return response()->json([
            'success' => true,
            'message' => 'Verification code resent successfully.',
        ], 200);
    }

    public function getAdmin($id)
    {

        try {
            $admin = Admin::findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => 'Admin retrieved successfully',
                'data' => Admin::with(['city:id,name'])->get()
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Admin not found',
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    public function index()
    {

        $admin = Admin::with([
            'city:id,name',
        ])->get();

        return response()->json([
            'status'=>true,
            'message'=>'Get Admins',
            'data'=> $admin ,
        ],200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'admin_name' => 'required|string|sometimes',
            'mobile_number' => 'sometimes|required|string|max:10',
            'date_of_birth' => 'sometimes|required|date',
            'id_number' => 'sometimes|required|string|max:10',
            'address' => 'sometimes|required|string',
            'description' => 'sometimes|nullable|string',
            'status' => 'integer',
            'city_id' => 'exists:cities,id',
        ]);
        try {
            DB::beginTransaction();

            $admin = Admin::findOrFail($id);
            $admin->update($request->all());

            DB::commit();

            return response()->json([
                'status'=>true,
                'message' => 'Admin updated successfully',
                'data' => $admin,
            ],200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while updating admin'], 500);
        }
    }




    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $admin = Admin::findOrFail($id);

            $admin->verificationCodes()->delete();

            $admin->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Admin deleted successfully',
            ],200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'error' => 'An error occurred while deleting admin',
                'message' => $e->getMessage(),
            ], 500);
                    }
    }



    public function logout(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        if ($admin) {
            $admin->tokens()->delete();
        }

        $admin->verificationCodes()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200); // HTTP status code 200 OK
    }

}
