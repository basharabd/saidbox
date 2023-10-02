<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeliveryManLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryManLocationsController extends Controller
{

    public function show($id)
    {
        $deliveryManLocation = DeliveryManLocation::query()
            ->select([
                'id',
                'captain_id',

                DB::raw("ST_X(current_location) As lat"),
                DB::raw("ST_Y(current_location) As lng"),

                'created_at',
                'updated_at',
            ])
            ->where('id', $id)
            ->firstOrFail();

        return $deliveryManLocation;

    }

    public function update(Request $request , DeliveryManLocation $deliveryManLocation)
    {
        $request->validate([
            'lng'=>['required' , 'numeric'],
            'lat'=>['required' , 'numeric'],
        ]);

        $deliveryManLocation->update([
            'current_location'=>DB::raw("POINT({$request->lng},{$request->lat})"),

        ]);

        return $deliveryManLocation;

    }
}
