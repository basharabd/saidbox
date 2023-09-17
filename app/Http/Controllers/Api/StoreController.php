<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Models\Store;
use App\Models\VerificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\RegisterNotification;


class StoreController extends Controller
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
        $store = Store::where('mobile_number', $phone)->first();

        if ($store) {
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
            ],404);
        }
    }


    public function signup(Request $request)
    {
        $request->validate([
            'store_type_id' => 'required|exists:store_types,id',
            'branch_id' => 'required|exists:branches,id',
            'city_id' => 'required|exists:cities,id',
            'store_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'integer|in:0,1',
            'mobile_number' => 'required|string|max:10|unique:stores,mobile_number',
            'image' => 'nullable|image', // Add image validation rules
        ]);

        try {
            DB::beginTransaction();

            // Create a new store instance
            $store = new Store($request->all());

            // Set the default image if no image is uploaded
            if (!$request->hasFile('image')) {
                // Assuming 'default-store-image.png' is located in the public/images directory
                $defaultImagePath = 'images/default-store-image.png';
                $store->image = $defaultImagePath;
            } else {
                // Handle image upload if a file is provided
                $image = $request->file('image');
                $path = $image->store('store_images', 'public');
                $store->image = $path;
            }

            // Save the store and related verification code
            $store->save();
            $user_secret = new VerificationCode([
                'phone' => $request->mobile_number,
                'code' => mt_rand(10000, 99999),
            ]);
            $store->verificationCodes()->save($user_secret);
            $store->notify(new RegisterNotification());

            DB::commit();

            return response()->json([
                'status'=>true,
                'message' => 'Store Created successfully',
                'code' => 'Send Code successfully',
            ],201);
        } catch (\Exception $e) {
            DB::rollBack();
            // Handle the exception
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()]
                , 500);
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
        $store = Store::where('mobile_number', $phone)->first();
        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'No store found with this phone number.',
            ], 404);
        }

        $verificationCode = VerificationCode::where('phone', $phone)->first();

        if (!$verificationCode || $verificationCode->code != $code) {
            return response()->json([
                'success' => false,
                'message' => 'Verification code does not match.',
            ], 400);
        } else {
            $store->update([
                'phone_verified_at' => Carbon::now(),
            ]);

            $verificationCode->delete();
            $token = $store->createToken('Personal Access Token')->plainTextToken;


            return response()->json([
                'success' => true,
                'message' => 'Login successfully.',
                'data'=>$store,
                'token'=>$token,
            ], 200);
        }
    }

    public function resend_code(Request $request)
    {

            $mobile_number = $request->mobile_number;

            $store = Store::where('mobile_number', $mobile_number)->first();

            if (!$store) {
                return response()->json([
                    'success' => false,
                    'message' => 'No store found with this phone number.',
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

    public function getStore($id)
    {

            try {
                $store = Store::findOrFail($id);

                return response()->json([
                    'status' => true,
                    'message' => 'Store retrieved successfully',
                    'data' => Store::with([
                    'branch:id,branch_name',
                    'city:id,name'

                    ])->get()
                ] , 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'error' => 'Store not found',
                    'message' => $e->getMessage(),
                ], 404);            }
    }

    public function index()
    {
        $stores = Store::with([
            'branch:id,branch_name',
            'city:id,name'
            ])->get();

        return response([
            'status'=>true,
            'data'=> $stores,

        ],200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'store_type_id' => 'required|exists:store_types,id',
            'branch_id' => 'required|exists:branches,id',
            'city_id' => 'required|exists:cities,id',
            'store_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'integer|in:0,1',
            'mobile_number' => 'required|string|max:10',
        ]);

        try {
            DB::beginTransaction();

            $store = Store::findOrFail($id);

            // Check if the mobile number is being updated
            if ($store->mobile_number !== $request->mobile_number) {
                // Delete the old verification code


                $store->verificationCodes()->delete();

                $store->update([
                    'mobile_number' => $request->mobile_number,
                    'phone_verified_at' => null,
                ]);
                // Generate a new verification code
                $code = mt_rand(10000, 99999);

                // Create and save the new verification code
                $verificationCode = new VerificationCode([
                    'phone' => $request->mobile_number,
                    'code' => $code,
                ]);
                $store->verificationCodes()->save($verificationCode);
            }

            // Update other store fields
            $store->update($request->all());

            DB::commit();

            return response()->json([
                'status' => true,
                'message' =>[
                    'Store updated successfully',
                    'Send Code successfully ',
                ],
                'data' => $store,
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

            $store = Store::findOrFail($id);

            $store->verificationCodes()->delete();

            $store->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Store deleted successfully',
            ],200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function getOrdersByStore($storeId)
    {
        $store = Store::find($storeId);

        if (!$store) {
            return response()->json([
                'message' => 'Store not found.',
            ], 404);
        }

        $orders = Order::with([
            'store:id,store_name',
            'size:id,size_type',
            'city:id,name',
            'captain:id,captain_name',
            'branch:id,branch_name',
        ])->where('store_id', $storeId)->get();

        return response()->json([
            'message' => 'Orders retrieved successfully.',
            'data' => $orders,
        ], 200);
    }


    public function logout(Request $request)
    {
        $store = Auth::guard('store')->user();

        if ($store) {
            $store->tokens()->delete();
        }

        $store->verificationCodes()->delete();

        return response()->json(['message' => 'Logged out successfully'],200);
    }




    public function updateImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max file size as needed
        ]);

        $store = Store::findOrFail($id);

        // Delete the old image if it exists
        if ($store->image) {
            Storage::disk('public')->delete('store_images/' . $store->image);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName(); // Get the original name of the image

            // Save the image in the public folder
            $path = $image->storeAs('store_images', $imageName, 'public');

            $store->image = $imageName; // Save the image name in the database
        }

        $store->save();

        return response()->json([
            'message' => 'Store image updated successfully',
            'data' => $store,
        ],200);
    }}
