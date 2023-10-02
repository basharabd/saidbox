<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SizesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sizes = Size::all();
        return view('dashboard.sizes.index' , compact('sizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.sizes.create');

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
            'size_type'=>'required|string',
            'price'=>'numeric',
        ]);

        try {
            DB::beginTransaction();
            // Create a new size instance
            $size = Size::create($request->all());
            // Save the branch
            $size->save();
            DB::commit();

            // Redirect to a view with a success message
            return redirect()->route('sizes.index')->with('success', 'Size created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            // Redirect to a view with an error message
            return redirect()->route('sizes.create')->with('error', 'An error occurred while creating the Size.');
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
           // Retrieve the Size record by its ID
           $size = Size::findOrFail($id);
           // Load the edit view with the reason data
           return view('dashboard.sizes.edit', compact('size'));
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
            'size_type'=>'required|string',
            'price'=>'numeric',
        ]);

        try {
            DB::beginTransaction();

            // Retrieve the size record by its ID
            $size = Size::findOrFail($id);

            // Update the size record with the new data
            $size->update($request->all());

            DB::commit();

            // Redirect to a view with a success message
            return redirect()->route('sizes.index')->with('success', 'Size updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            // Redirect to the edit view with an error message
            return redirect()->route('sizes.edit', $id)->with('error', 'An error occurred while updating the Size.');
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
            // Find the size record by its ID
            $size = Size::findOrFail($id);

            // Delete the reason record
            $size->delete();

            // Redirect to a view with a success message
            return redirect()->route('sizes.index')->with('success', 'Size deleted successfully');
        } catch (\Exception $e) {
            // Handle any exceptions or errors that may occur during deletion
            return redirect()->route('sizes.index')->with('error', 'An error occurred while deleting the Size.');
        }
    }
}
