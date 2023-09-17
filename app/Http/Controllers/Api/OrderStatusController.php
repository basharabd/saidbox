<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{

    public function getOrderTrackingStatus()
    {
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

        // Return the response in JSON format
        return response()->json([
            'tracking' => $tracking,
        ]);
    }


    public function index()
    {
        $orderStatus = OrderStatus::all();
        return response()->json([
            'status' => 'success',
            'data' => $orderStatus,
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'time' => 'nullable|date',
        ]);

        // Create a new order status
        $orderStatus = OrderStatus::create([
            'name'=>$request->name,
            'time'=>now(),
        ]);

        return response()->json([
            'message' => 'Order status created successfully.',
            'data' => $orderStatus,
        ], 201);
    }


    public function show(OrderStatus $orderStatus)
    {
        return response()->json([
            'message' => 'Order status retrieved successfully.',
            'data' => $orderStatus,
        ]);    }


    public function update(Request $request, OrderStatus $orderStatus)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'time' => 'nullable|date',
        ]);

        // Update the order status
        $orderStatus->update($request->all());

        return response()->json([
            'message' => 'Order status updated successfully.',
            'data' => $orderStatus,
        ]);
    }


    public function destroy(OrderStatus $orderStatus)
    {
        // Delete the order status
        $orderStatus->delete();

        return response()->json([
            'message' => 'Order status deleted successfully.',
        ]);
    }

}
