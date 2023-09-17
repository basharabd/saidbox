<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StoreType;
use Illuminate\Http\Request;

class StoreTypeController extends Controller
{

    public function index()
    {

        $storeTypes = StoreType::all();

        return response()->json([
            'status' => true,
            'data' => $storeTypes,
        ],200);

    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:store_types,name',
        ]);

        $storeType = StoreType::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Store type created successfully',
            // 'data' => $storeType,
        ],201);
    }


    public function show(string $id)
    {
        $storeType = StoreType::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $storeType,
        ],200);
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:store_types,name,' . $id,
        ]);

        $storeType = StoreType::findOrFail($id);

        $storeType->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Store type updated successfully',
        ], 200);
    }

    public function destroy($id)
    {

       $storeType = StoreType::findOrFail($id);
       $storeType->delete();
       return response()->json([
           'status' => 'success',
           'message' => 'Store type deleted successfully',
       ],200);
    }
}
