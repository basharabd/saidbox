<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SizeController extends Controller
{

    public function getsize($sizeId)
    {
        $size = Size::findOrFail($sizeId);
        return response()->json([
            'status'=>'true',
            'message' => 'Get Branch Successfully',
            'data' => $size->toArray(),
        ],200);
    }
    public function sizes()
    {

        $sizes = Size::all();

        return response()->json([
            'status'=>true,
            'message' => 'Get Sizes Successfully',
            'data'=>$sizes,
        ],200);

    }

    public function storeSize(Request $request)
    {
        $request->validate([
            'size_type'=>'required|unique:sizes',
            'price'=>'required',
        ]);

        try {
            DB::beginTransaction();

            // Create a new size instance
            $size = new Size($request->all());

            // Save the size
            $size->save();

            DB::commit();

            return response()->json([
                'status'=>true,
                'message' => 'Size created successfully',
                'data' => $size,
            ],201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }



    }

    public function updateSize(Request $request, $id)
    {
        $request->validate([
            'size_type' => 'required|unique:sizes,size_type,' . $id,
            'price' => 'required',
        ]);

        try {
            DB::beginTransaction();

            // Find the size based on the provided ID
            $size = Size::findOrFail($id);

            // Update the size's attributes
            $size->size_type = $request->size_type;
            $size->price = $request->price;

            // Save the changes to the database
            $size->save();

            DB::commit();

            return response()->json([
                'status'=>true,
                'message' => 'Size updated successfully',
                'data' => $size,
            ],200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function destroy(string $id)
    {
        $size = Size::findOrFail($id);
        $size->delete();
        return response()->json([
            'status'=>true,
            'message' => 'Size deleted successfully'
        ],200);
     }



}
