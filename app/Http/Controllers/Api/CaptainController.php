<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\GatewaySms;
use App\Models\Admin;
use App\Models\Captain;
use App\Models\DeviceToken;
use App\Models\Store;
use App\Models\VerificationCode;
use App\Notifications\CaptainNotificationFcm;
use App\Notifications\StoreNotificationFcm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;



class CaptainController extends Controller
{

    public $smsService;
    public function __construct(GatewaySms $smsService)
    {

        $this->smsService = $smsService;

    }

    public function login(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|string|max:10',
        ]);

        $phone = $request->input('mobile_number');
        $captain = Captain::where('mobile_number', $phone)->first();

        if ($captain) {
            $code = mt_rand(10000, 99999);
            VerificationCode::create([
                'phone' => $phone,
                'code' =>'11111',// $code,
            ]);
            return response()->json([
                'status'=>true,
                'message' => 'send Code successfully',
            ],200);

        } else {
            return response()->json([
                'status'=>false,
                'message' => 'Mobile number is not registered. Please proceed with registration.',
            ],404);
        }
    }
    public function signup(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'captain_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:10|unique:captains,mobile_number',
            'date_of_birth' => 'required|date',
            'id_number' => 'required|string|max:255',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'integer',
            'city_id' => 'required|exists:cities,id',
            'token'=>'required',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Create a new Captain instance
            $captain = Captain::create($request->except('token'));
            // Create a new device token
            $deviceToken = new DeviceToken([
                'token' => $request->input('token'),
                'device' => '@',
            ]);
            $captain->deviceTokens()->save($deviceToken);

            // Save the Captain and related verification code
            $userSecret = new VerificationCode([
                'phone' => $request->input('mobile_number'),
                'code' => '11111'//mt_rand(10000, 99999),
            ]);

            $captain->verificationCodes()->save($userSecret);

            $notification = $captain->notify(new CaptainNotificationFcm($captain));


            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Captain created successfully',
                'code' => 'Verification code sent successfully',
                'notification'=>'Send Notification successfully',
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
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
        $captain = Captain::where('mobile_number', $phone)->first();
        if (!$captain) {
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
            $captain->update([
                'phone_verified_at' => Carbon::now(),
            ]);

            $verificationCode->delete();
            $token = $captain->createToken('Personal Access Token')->plainTextToken;


            return response()->json([
                'success' => true,
                'message' => 'Login successfully.',
                'data'=>$captain,
                'token'=>$token,
            ], 200);
        }
    }

    public function resendCode(Request $request)
    {

            $mobile_number = $request->mobile_number;

            $captain = Captain::where('mobile_number', $mobile_number)->first();

            if (!$captain) {
                return response()->json([
                    'success' => false,
                    'message' => 'No Captain found with this phone number.',
                ], 404);
            }

            $verificationCode = VerificationCode::updateOrCreate(

                ['phone'=>$request->mobile_number],

                ['code' =>'11111'],// rand(10000, 99999)],
            );

            return response()->json([
                'success' => true,
                'message' => 'Verification code resent successfully.',
            ], 200);
    }
    public function getCaptain($id)
    {

            try {
                $captain = Captain::findOrFail($id);

                return response()->json([
                    'status' => true,
                    'message' => 'Store retrieved successfully',
                    'data' => Captain::with(['city:id,name'])->get()
                ],200);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
    }

    public function index()
    {

        $captains = Captain::with([

            'city:id,name',
        ])->get();

        return response()->json([
            'status'=>true,
            'message'=>'Get Captains',
            'data'=> $captains ,
        ],200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'captain_name' => 'required|string|sometimes',
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

            $captain = Captain::findOrFail($id);
            $captain->update($request->all());

            DB::commit();

            return response()->json([
                'status'=>true,
                'message' => 'Captain updated successfully',
                'data' => $captain,
            ],200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $captain = Captain::findOrFail($id);

            $captain->verificationCodes()->delete();

            $captain->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Captain deleted successfully',
            ],200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function logout(Request $request)
    {
        $captain = Auth::guard('captain')->user();

        if ($captain) {
            $captain->tokens()->delete();
        }
        $captain->verificationCodes()->delete();

        return response()->json(['message' => 'Logged out successfully'],200);
    }



}
