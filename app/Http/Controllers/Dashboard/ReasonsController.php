<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Reason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReasonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reasons = Reason::all();
        return view('dashboard.reasons.index' , compact('reasons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.reasons.create');
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
            'reason'=>'required|string',
            'description'=>'nullable|string',
        ]);

        try {
            DB::beginTransaction();
            // Create a new reason instance
            $reason = Reason::create($request->all());
            // Save the branch
            $reason->save();
            DB::commit();

            // Redirect to a view with a success message
            return redirect()->route('reason.index')->with('success', 'Reason created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            // Redirect to a view with an error message
            return redirect()->route('reason.create')->with('error', 'An error occurred while creating the reason.');
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
               // Retrieve the reason record by its ID
               $reason = Reason::findOrFail($id);
               // Load the edit view with the reason data
               return view('dashboard.reasons.edit', compact('reason'));
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
        $request->validate([
            'reason'=>'required|string',
            'description'=>'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Retrieve the branch record by its ID
            $reason = Reason::findOrFail($id);

            // Update the branch record with the new data
            $reason->update($request->all());

            DB::commit();

            // Redirect to a view with a success message
            return redirect()->route('reason.index')->with('success', 'Reason updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            // Redirect to the edit view with an error message
            return redirect()->route('reason.edit', $id)->with('error', 'An error occurred while updating the reason.');
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
            // Find the reason record by its ID
            $reason = Reason::findOrFail($id);

            // Delete the reason record
            $reason->delete();

            // Redirect to a view with a success message
            return redirect()->route('reason.index')->with('success', 'Reason deleted successfully');
        } catch (\Exception $e) {
            // Handle any exceptions or errors that may occur during deletion
            return redirect()->route('reason.index')->with('error', 'An error occurred while deleting the reason.');
        }
    }
}