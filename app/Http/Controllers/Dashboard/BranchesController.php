<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $branches = Branch::all();
       return view('dashboard.branches.index' , compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $cities = City::all();
        return view('dashboard.branches.create' , compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
        public function store(Request $request)
        {

            $request->validate([
                'branch_name' => 'required',
                'address' => 'nullable',
                'mobile_number' => 'required|unique:branches,mobile_number',
            ]);

            try {
                DB::beginTransaction();
                // Create a new branch instance
                $branch = new Branch($request->all());
                // Save the branch
                $branch->save();
                DB::commit();

                // Redirect to a view with a success message
                return redirect()->route('branches.index')->with('success', 'Branch created successfully');
            } catch (\Exception $e) {
                DB::rollBack();
                // Redirect to a view with an error message
                return redirect()->route('branches.create')->with('error', 'An error occurred while creating the branch.');
            }
        }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Retrieve the branch record by its ID
        $branch = Branch::findOrFail($id);
        $cities = City::all();
        // Load the edit view with the branch data
        return view('dashboard.branches.edit', compact('branch' , 'cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $request->validate([
            'branch_name' => 'required|string',
            'address' => 'nullable|string', // Updated to accept string or null
            'mobile_number' => 'required|unique:branches,mobile_number,' . $id, // Include ID to ignore the current record
        ]);

        try {
            DB::beginTransaction();

            // Retrieve the branch record by its ID
            $branch = Branch::findOrFail($id);

            // Update the branch record with the new data
            $branch->update($request->all());

            DB::commit();

            // Redirect to a view with a success message
            return redirect()->route('branches.index')->with('success', 'Branch updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            // Redirect to the edit view with an error message
            return redirect()->route('branches.edit', $id)->with('error', 'An error occurred while updating the branch.');
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            // Find the branch record by its ID
            $branch = Branch::findOrFail($id);

            // Delete the branch record
            $branch->delete();

            // Redirect to a view with a success message
            return redirect()->route('branches.index')->with('success', 'Branch deleted successfully');
        } catch (\Exception $e) {
            // Handle any exceptions or errors that may occur during deletion
            return redirect()->route('branches.index')->with('error', 'An error occurred while deleting the branch.');
        }
    }



    public function updateStatus(Request $request)
    {
        $branchId = $request->input('branch_id');
        $newStatus = $request->input('status');

        try {
            $branch = Branch::findOrFail($branchId);
            $branch->update(['status' => $newStatus]);

            return response()->json(['success' => true, 'message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating status']);
        }
    }


    public function search(Request $request)
    {
        $branchName = $request->input('branch_name');
        $status = $request->input('status');

        $branches = Branch::query();

        if ($branchName) {
            $branches->where('branch_name', 'like', '%' . $branchName . '%');
        }

        if ($status) {
            $branches->where('status', $status);
        }

        $results = $branches->get();

        return response()->json($results);
    }



}
