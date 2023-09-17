<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reason;
use Illuminate\Http\Request;

class ReasonController extends Controller
{

    public function index()
    {
        $reasons = Reason::all();
        return response()->json([
            'status' => true,
            'message'=>'Get Reasons successfully',
            'data' => $reasons,
        ],200);
    }


    public function store(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:255|unique:reasons',
        ]);

        $reason = Reason::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Reason created successfully',
            'data' => $reason,
        ],201);
    }


    public function show(Reason $reason)
    {
        return response()->json([
            'status' => true,
            'message' => 'Reason Show successfully',
            'data' => $reason,
        ],200);
    }


    public function update(Request $request, Reason $reason)
    {
        $request->validate([
            'reason' => 'required|string|max:255|unique:reasons,reason,' . $reason->id,
        ]);

        $reason->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Reason updated successfully',
            'data' => $reason,
        ], 200);
    }


//    public function destroy(Reason $reason)
//    {
//        $reason->delete();
//
//        return response()->json([
//            'status' => true,
//            'message' => 'Reason deleted successfully',
//        ],200);
//    }

    public function destroy($reasonId)
    {
        $reason = Reason::find($reasonId);

        if (!$reason) {
            return response()->json([
                'status' => false,
                'message' => 'Reason not found',
            ], 404);
        }

        $reason->delete();

        return response()->json([
            'status' => true,
            'message' => 'Reason deleted successfully',
        ], 200);
    }


}
