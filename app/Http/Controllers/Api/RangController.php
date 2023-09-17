<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rang;
use Illuminate\Http\Request;

class RangController extends Controller
{


    public function index()
    {
        $rangs = Rang::all();
        return response()->json([
            'status'=>true,
            'message'=>'Get Rang Successfully',
            'data'=> Rang::with([
                'city:id,name',
                'toCity:id,name',
            ])->get(),
        ],200);
    }

    // public function show($id)
    // {
    //     $rang = Rang::findOrFail($id);
    //     return response()->json([
    //         'status'=>true,
    //         'message'=>'Get One Rang Successfully',
    //         'data'=> Rang::with([
    //             'city:id,name',
    //             'toCity:id,name',
    //         ])->get()
    //     ]);
    // }

    public function store(Request $request)
    {
        // $request->validate([
        //     'city_id' => 'required|exists:cities,id',
        //     'to_city_id' => 'required|exists:cities,id',
        //     'price' => 'required',
        // ]);

        $rang =  new Rang($request->all());
        $rang->save();
        return response()->json([
            'status'=>true,
            'message'=>'Create Rang Successfully',
            'data'=> $rang,
        ],201);
    }

    public function update(Request $request, $id)
    {
        $rang = Rang::findOrFail($id);
        $rang->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Update Rang Successfully',
            'data' => $rang,
        ], 200);
    }

    public function destroy($id)
    {
        $rang = Rang::findOrFail($id);
        $rang->delete();
        return response()->json([
            'status'=>true,
            'message'=>'Delete Rang Successfully',

        ],200);
      }


}
