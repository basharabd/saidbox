<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Rang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{

    public function getcity($cityId)
    {
        $city = City::findOrFail($cityId);
        return response()->json([
            'status'=>true,
            'message' => 'Get City Successfully',
            'data' => $city,
        ],200);
    }
    public function cities()
    {
        $Rang = City::with('Rang')->get();
        return response()->json([
            'status'=>true,
            'message' => 'Get Cities Successfully',
            'data'=>$Rang,
        ],200);
    }

    public function storeCity(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:cities',
        ]);
        try {
            DB::beginTransaction();
            $city = new City($request->all());
            $city->save();
            DB::commit();
            return response()->json([
                'status'=>true,
                'message' => 'City created successfully',
                'data' => $city,
            ],201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'=>true,
                'error' => $e->getMessage()
            ], 500);
        }
    }

//    public function updateCity(Request $request, $id)
//    {
//        $request->validate([
//            'name' => 'required|unique:cities,name,' . $id,
//        ]);
//
//        try {
//            DB::beginTransaction();
//
//            // Find the city based on the provided ID
//            $city = City::findOrFail($id);
//
//            // Update the city's attributes
//            $city->name = $request->name;
//
//            // Save the changes to the database
//            $city->save();
//
//            DB::commit();
//
//            return response()->json([
//                'status'=>true,
//
//                'message' => 'City updated successfully',
//                'data' => $city,
//            ],200);
//        } catch (\Exception $e) {
//            DB::rollBack();
//            return response()->json(['error' => $e->getMessage()], 500);
//        }
//    }
    public function updateCity(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:cities,name,' . $id,
        ]);

        try {
            DB::beginTransaction();

            // Find the city based on the provided ID
            $city = City::findOrFail($id);

            // Update the city's attributes
            $city->name = $request->input('name'); // Access the 'name' from the request body

            // Save the changes to the database
            $city->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'City updated successfully',
                'data' => $city,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


//    public function destroy(string $id)
//    {
//        $city = City::findOrFail($id);
//        $city->delete();
//        return response()->json([
//            'status'=>true,
//            'message' => 'City deleted successfully'
//        ],200);
//    }


    public function destroy(Request $request, string $id)
    {
        $city = City::findOrFail($id);
        $city->delete();
        return response()->json([
            'status' => true,
            'message' => 'City deleted successfully'
        ], 200);
    }


}
