<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function getbranch($branchId)
     {
         $branch = Branch::findOrFail($branchId);
         return response()->json([
             'status'=>'true',
             'message' => 'Get Branch Successfully',
             'data' => $branch->toArray(),
         ]);
     }


    public function index()
    {
        $branches = Branch::all();
        return response()->json([
            'status'=>true,
            'message' => 'Get Branches Successfully',
            'data'=>$branches,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

            'branch_name'=>'required',
            'address'=>'nullable',
            'mobile_number'=>'required|unique:branches,mobile_number',
        ]);

        try {
            DB::beginTransaction();
            // Create a new city instance
            $branch = new Branch($request->all());
            // Save the city
            $branch->save();
            DB::commit();
            return response()->json([
                'message' => 'Branch created successfully',
                'data' => $branch,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
//    public function update(Request $request, string $id)
//    {
//        $request->validate([
//            'branch_name' => 'required',
//            'address' => 'nullable',
//            'mobile_number' => "required|unique:branches,mobile_number,{$id}"
//        ]);
//
//        try {
//            DB::beginTransaction();
//            // Find the branch record based on the given ID
//            $branch = Branch::findOrFail($id);
//
//            // Update the branch details
//            $branch->branch_name = $request->branch_name;
//            $branch->address = $request->address;
//            $branch->mobile_number = $request->mobile_number;
//
//            // Save the updated branch
//            $branch->save();
//            DB::commit();
//
//            return response()->json([
//                'message' => 'Branch updated successfully',
//                'data' => $branch,
//            ]);
//        } catch (\Exception $e) {
//            DB::rollBack();
//            return response()->json(['error' => $e->getMessage()], 500);
//        }
//    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'branch_name' => 'required',
            'address' => 'nullable',
            'mobile_number' => "required|unique:branches,mobile_number,{$id}",
            'email' => 'nullable',
            'status' => 'nullable',
            'city_id' => 'nullable',


        ]);

        try {
            DB::beginTransaction();
            // Find the branch record based on the given ID
            $branch = Branch::findOrFail($id);

            // Update the branch details
            $branch->branch_name = $request->branch_name;
            $branch->address = $request->address;
            $branch->mobile_number = $request->mobile_number;
            $branch->email = $request->email;
            $branch->status = $request->status;



            // Save the updated branch
            $branch->save();
            DB::commit();

            return response()->json([
                'message' => 'Branch updated successfully',
                'data' => $branch,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();
        return response()->json([
            'status' => true,
            'message' => 'Branch deleted successfully'
        ]);
    }

}
