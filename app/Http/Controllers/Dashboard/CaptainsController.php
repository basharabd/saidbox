<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Captain;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CaptainsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $captains = Captain::all();
        return view('dashboard.captains.index' , compact('captains'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all();

        return view('dashboard.captains.create' , compact('cities'));

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
            'captain_name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'mobile_number' => 'required|unique:captains,mobile_number|max:10',
            'id_number' => 'required|string|max:20|unique:captains|max:10',
            'date_of_birth' => 'required|date',
            'status' => 'required|in:0,1',
        ]);

        try {
            DB::beginTransaction();

            // Create the Captain instance and save it to the database
            Captain::create($request->all());

            DB::commit();

            // Redirect to a view with a success message
            return redirect()->route('captains.index')->with('success', 'Captain created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            // Redirect to a view with an error message
            return redirect()->route('captains.create')->with('error', 'An error occurred while creating the captain.');
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
        try {
            $captain = Captain::findOrFail($id);
            $cities = City::all(); // You may need to import the City model

            return view('dashboard.captains.edit', compact('captain', 'cities'));
        } catch (\Exception $e) {
            // Handle the case where the Captain with the given ID is not found
            return redirect()->route('captains.index')->with('error', 'Captain not found');
        }
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
                'captain_name' => 'required|string|max:255',
                'city_id' => 'required|exists:cities,id',
                'address' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
                'mobile_number' => 'required|unique:captains,mobile_number|max:10,' . $id, // Ignore the current Captain's ID
                'id_number' => 'required|string|max:20|unique:captains,id_number|max:10,' . $id, // Ignore the current Captain's ID
                'date_of_birth' => 'required|date',
                'status' => 'required|in:0,1',
            ]);

            try {
                DB::beginTransaction();

                // Find the Captain record by its ID
                $captain = Captain::findOrFail($id);

                // Update the Captain record with the new data
                $captain->update($request->all());

                DB::commit();

                // Redirect to a view with a success message
                return redirect()->route('captains.index')->with('success', 'Captain updated successfully');
            } catch (\Exception $e) {
                DB::rollBack();

                // Redirect to a view with an error message
                return redirect()->route('captains.edit', $id)->with('error', 'An error occurred while updating the Captain.');
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
            $captain = Captain::findOrFail($id);

            DB::beginTransaction();
            $captain->delete();
            DB::commit();

            return redirect()->route('captains.index')->with('success', 'Captain deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            // Handle the case where the Captain with the given ID is not found or deletion fails
            return redirect()->route('captains.index')->with('error', 'An error occurred while deleting the Captain');
        }
    }


    public function updateStatus(Request $request)
    {
        $captainId = $request->input('captain_id');
        $newStatus = $request->input('status');

        try {
            $captain = Captain::findOrFail($captainId);
            $captain->update(['status' => $newStatus]);

            return response()->json(['success' => true, 'message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating status']);
        }
    }



}
