<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\StoreType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $storeTypes = StoreType::all();

        return view('dashboard.store_type.index', compact('storeTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.store_type.create');
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
            'name' => 'required|string',
        ]);

        try {
            DB::beginTransaction();
            $storeType = StoreType::create($request->all());
            DB::commit();

            return redirect()->route('type_store.index')->with('success', 'Store Type created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('type_store.create')->with('error', 'An error occurred while creating the Store Type.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $storeType = StoreType::findOrFail($id);
        return view('dashboard.store_type.edit', compact('storeType'));
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
            'name' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $storeType = StoreType::findOrFail($id);

            $storeType->update($request->all());
            DB::commit();

            return redirect()->route('type_store.index')->with('success', 'Store Type updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('type_store.edit', $id)->with('error', 'An error occurred while updating the Store Type.');
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
            $storeType = StoreType::findOrFail($id);

            $storeType->delete();

            return redirect()->route('type_store.index')->with('success', 'Store Type deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('type_store.index')->with('error', 'An error occurred while deleting the Store Type.');
        }
    }
}