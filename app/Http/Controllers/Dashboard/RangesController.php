<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Rang;
use Illuminate\Http\Request;

class RangesController extends Controller
{

    public function index()
    {
        $ranges = Rang::all();

        return view('dashboard.ranges.index'  , compact('ranges' ));
    }


    public function create()
    {
        $cities = City::pluck('name', 'id');
        return view('dashboard.ranges.create' , compact('cities'));
    }


    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'city_id' => 'required', // Add any validation rules you need
            'to_city_id' => 'required', // Add any validation rules you need
            'price' => 'required|numeric', // Add any validation rules you need
        ]);

        // Create a new Rang instance with the validated data
        $rang = new Rang([
            'city_id' => $request->input('city_id'),
            'to_city_id' => $request->input('to_city_id'),
            'price' => $request->input('price'),
        ]);

        // Save the Rang instance to the database
        $rang->save();

        // Redirect to the index page with a success message
        return redirect()->route('ranges.index')->with('success', 'Rang created successfully');
    }



    public function show($id)
    {

    }


    public function edit($id)
    {
                    // Fetch the range by its ID
            $range = Rang::findOrFail($id);

            // Retrieve the list of cities
            $cities = City::pluck('name', 'id'); // Adjust this based on your database schema

            return view('dashboard.ranges.edit', compact('range', 'cities'));

    }


    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $request->validate([
            'city_id' => 'required', // Add any validation rules you need
            'to_city_id' => 'required', // Add any validation rules you need
            'price' => 'required|numeric', // Add any validation rules you need
        ]);

        // Find the Rang record by its ID
        $rang = Rang::findOrFail($id);

        // Update the record with the new data
        $rang->city_id = $request->input('city_id');
        $rang->to_city_id = $request->input('to_city_id');
        $rang->price = $request->input('price');

        // Save the updated record
        $rang->update();

        // Redirect to the index page with a success message
        return redirect()->route('ranges.index')->with('success', 'Rang updated successfully');
    }



    public function destroy($id)
    {
        // Find the Rang record by its ID
        $rang = Rang::findOrFail($id);

        // Delete the record from the database
        $rang->delete();

        // Redirect to the index page with a success message
        return redirect()->route('ranges.index')->with('success', 'Rang deleted successfully');
    }
}