<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminWallet;
use App\Models\Captain;
use App\Models\CaptainWallet;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\OrderTransaction;
use App\Models\Rang;
use App\Models\Reason;
use App\Models\Store;
use App\Models\StoreWallet;
use App\Notifications\NewOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notification;



class OrderController extends Controller
{

    public function getOrder($orderId)
    {
        $order = Order::findOrFail($orderId);
        return response()->json([
            'status'=>'true',
            'message' => 'Get Order Successfully',
            'data' => Order::with([
                'store:id,store_name',
                'size:id,size_type',
                'city:id,name',
                'captain:id,captain_name',
                'branch:id,branch_name',
            ])->get(),
            ]);
    }
//
//    public function getOrders()
//    {
//        $orders = Order::all();
//        return response()->json([
//            'status'=>'true',
//            'message' => 'Get Orders Successfully',
//            'data' => Order::with([
//                'store:id,store_name',
//                'size:id,size_type,price',
//                'city:id,name',
//                'captain:id,captain_name',
//                'branch:id,branch_name',
//            ])->get(),
//
//        ]);
//    }

//    public function getOrders()
//    {
//        $orders = Order::with([
//            'store:id,store_name',
//            'size:id,size_type,price',
//            'city:id,name',
//            'captain:id,captain_name',
//            'branch:id,branch_name',
//            'orderTransaction' // Load the order transaction relationship
//        ])->get();
//
//        $data = $orders->map(function ($order) {
//            return [
//                'id' => $order->id,
//                'store' => $order->store,
//                'size' => $order->size,
//                'city' => $order->city,
//                'captain' => $order->captain,
//                'branch' => $order->branch,
//                'order_price' => $order->orderTransaction->order_price,
//                'delivery_fees' => $order->orderTransaction->delivery_fees,
//                'subtotal' => $order->orderTransaction->subtotal,
//                'total' => $order->orderTransaction->total,
//            ];
//        });
//
//        return response()->json([
//            'status' => 'true',
//            'message' => 'Get Orders Successfully',
//            'data' => $data,
//        ]);
//    }


    public function getOrders()
    {
        $orders = Order::with([
            'store:id,store_name',
            'size:id,size_type,price',
            'city:id,name',
            'captain:id,captain_name',
            'branch:id,branch_name',
            'orderTransaction', // Load the order transaction relationship
        ])->get();

        $data = [];

        foreach ($orders as $order) {
            // Ensure numeric casting for calculation
            $orderTransaction = $order->orderTransaction;
            $subtotal = (float) $orderTransaction->subtotal;
            $delivery_fees = (float) $orderTransaction->delivery_fees;
            $total = $subtotal + $delivery_fees;

            $data[] = [
                'id' => $order->id,
                'store_name' => $order->store->store_name,
                'size_type' => $order->size->size_type,
                'price' => (float) $order->size->price,
                'city' => $order->city->name,
                'captain_name' => $order->captain->captain_name,
                'branch_name' => $order->branch->branch_name,
                'total' => $total,
                'subtotal' => $subtotal,
                'delivery_fees' => $delivery_fees,
            ];
        }

        return response()->json([
            'status' => 'true',
            'message' => 'Get Orders Successfully',
            'data' => $data,
        ]);
    }


    public function storeOrder(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|string|max:10|unique:orders,mobile_number',
            'name' => 'required|string|max:255',
            'city_id' => 'required|numeric|exists:cities,id',
            'size_id' => 'required|numeric|exists:sizes,id',
            'address' => 'required|string',
            'order_price' => 'required|numeric',

            'order_note' => 'nullable|string',
            'captain_id' => 'required|numeric|exists:captains,id',
            'branch_id' => 'required|numeric|exists:branches,id',
            'store_id' => 'required|numeric|exists:stores,id',
            'package'=>'required|numeric',
            'admin_commission' => 'required|numeric',
            'store_commission' => 'required|numeric',
            'captain_commission' => 'required|numeric',
            'order_type' => 'required|string',
            'number'=>'unique:orders,number',
            'delivery_fees' => 'required',
        ]);

        try {
            DB::beginTransaction();

            // Calculate fees and total
            $fees = $request->delivery_fees; //store , admin , captain
            $city_id = $request->city_id;
            $range = Rang::where('id', $city_id)->first();
            $rang_price = $range->price;

            if ($fees == 'store') {
                $subtotal = $request->order_price + $rang_price;
                $delivery_fees = $rang_price;
                $total = $subtotal;
            } elseif ($fees == 'customer') {
                $subtotal = $request->order_price + $rang_price;
                $delivery_fees = $rang_price;
                $total = $subtotal;
            } elseif ($fees == 'admin') {
                $subtotal = $request->order_price;
                $delivery_fees = 0;
                $total = $subtotal;
            } else {
                DB::rollback();
                return response()->json(['error' => 'No Delivery Fees'], 400);
            }

            // Create a new order instance
            $order = Order::create([
                'store_id' => $request->store_id,
                'city_id' => $request->city_id,
                'size_id' => $request->size_id,
                'captain_id' => $request->captain_id,
                'branch_id' => $request->branch_id,
                'name' => $request->name,
                'mobile_number' => $request->mobile_number,
                'address' => $request->address,
                'order_type' => $request->order_type,
                'order_note' => $request->order_note,
                'request_order' => $request->request_order,
                'order_status_id' => OrderStatus::where('name', 'pending')->value('id'),
            ]);


            // Create the order detail
            $orderDetail = OrderTransaction::create([
                'order_id' => $order->id,
                'order_price' =>   intval($request->order_price),
                'admin_collect' =>  intval($request->admin_collect),
                'store_collect' =>  intval($request->store_collect),
                'delivery_collect' =>   intval($request->delivery_collect),
                'delivery_fees' => $request->delivery_fees,
                'fees' => $delivery_fees,
                'subtotal' => $subtotal,
                'total' => $total,
            ]);

            $store = Store::find($order->store_id);
            $tokens = $store->deviceTokens->pluck('token');

          //  $store->notify(new NewOrderNotification($order));
            // Get all the order status names
            $orderStatuses = OrderStatus::pluck('name');

            // Initialize an empty array to store the tracking information
            $tracking = [];

            // Loop through each status and set the tracking information
            foreach ($orderStatuses as $status) {
                $tracking[$status] = [
                    'status' => $status === 'pending',
                    'time' => $status === 'pending' ? now() : null,
                ];
            }

            // Admin Wallet
            $adminId = Admin::pluck('id')->first();
            $totalEarning = OrderTransaction::sum('admin_collect');

            $adminWallet = AdminWallet::where('admin_id', $adminId)->first();

            if (!$adminWallet) {
                $adminWallet = new AdminWallet();
                $adminWallet->admin_id = $adminId;
            }

            $adminWallet->total_earning = $totalEarning;
            $adminWallet->total_withdrawal = 0;
            $adminWallet->balance = $totalEarning - $adminWallet->total_withdrawal;
            $adminWallet->save();

            // Captain Wallet
            $captainId = $request->captain_id;
            $totalEarning = OrderTransaction::sum('delivery_collect');

            $captainWallet = CaptainWallet::where('captain_id', $captainId)->first();

            if (!$captainWallet) {
                $captainWallet = new CaptainWallet();
                $captainWallet->captain_id = $captainId;
            }

            $captainWallet->total_earning = $totalEarning;
            $captainWallet->total_withdrawal = 0;
            $captainWallet->balance = $totalEarning - $captainWallet->total_withdrawal;
            $captainWallet->save();

            // Store Wallet
            $storeId = $request->store_id;
            $branchId = $request->branch_id;
            $totalEarning = OrderTransaction::sum('store_collect');

            $storeWallet = StoreWallet::where('store_id', $storeId)->where('branch_id', $branchId)->first();

            if (!$storeWallet) {
                $storeWallet = new StoreWallet();
                $storeWallet->store_id = $storeId;
                $storeWallet->branch_id = $branchId;
            }

            $storeWallet->total_earning = $totalEarning;
            $storeWallet->total_withdrawal = 0;
            $storeWallet->balance = $totalEarning - $storeWallet->total_withdrawal;
            $storeWallet->save();


            $order->notify(new NewOrderNotification($order));


            DB::commit();

            return response()->json([
                'message' => 'Order created successfully',
                'order' => Order::with([
                    'store:id,store_name',
                    'size:id,size_type,price',
                    'city:id,name',
                    'captain:id,captain_name',
                    'branch:id,branch_name',
                ])->get(),
            //    'order_detail' => $orderDetail,
                'tracking' => $tracking,
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => 'Order creation failed: ' . $e->getMessage(),
            ], 500);
        }
    }



    public function canceledOrder(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'reason_id' => 'required|exists:reasons,id',
        ]);

        try {
            DB::beginTransaction();
            $order = Order::findOrFail($request->order_id);
            $order->order_status_id = '8';
            $order->reason_id = $request->reason_id;
            $order->save();
            DB::commit();

            // Get the reason associated with the updated order
            $reason = Reason::findOrFail($request->reason_id);

            return response()->json([
                'status' => 'true',
                'message' => 'Order has been cancelled successfully',
                'data' => [
                    'order' => $order,
                    'reason' => $reason,
                ],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }




    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'order_status' => 'required|exists:order_statuses,name',
        ]);

        try {
            DB::beginTransaction();
            $order = Order::findOrFail($id);
            $statusName = $request->order_status;

            // Get the order status instance by name
            $status = OrderStatus::where('name', $statusName)->first();

            if (!$status) {
                throw new \Exception('Invalid order status.');
            }

            $order->order_status_id = $status->id;
            $order->save();
            DB::commit();

            return response()->json([
                'status' => 'true',
                'message' => 'Order status updated successfully',
                'data' => [
                    'order' => $order,
                    'status' => $status,
                ],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


   public function show(Order $order)
   {

   }








}
