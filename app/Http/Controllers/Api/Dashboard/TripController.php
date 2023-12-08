<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Models\Trip;
use App\Models\Booking;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Requests\TripRequest;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::all();
        return response()->json($trips);
    }
    public function store(TripRequest $request)
    {
        $data = $request->all();
        $trip = Trip::create($data);
        return response()->json([
        'message' => 'Trip created successfully',
        'trip' => $trip], 201);
    }
    public function update(TripRequest $request, string $id)
    {
        $trip = Trip::find($id);
        if (!$trip) {return response()->json(['error' => 'Trip not found'], 404);}
        $data = $request->all();
        $trip->update($data);
        return response()->json([
        'message' => 'Trip updated successfully',
        'trip' => $trip], 201);
    }
    public function show($trip)
    {
        $trip = Trip::find($trip);
        if (!$trip) {return response()->json(['error' => 'Trip not found'], 404);}
        return response()->json(['trip' => $trip], 200);
    }
    public function destroy($trip)
    {
        $trip = Trip::find($trip);
        if (!$trip) {return response()->json(['error' => 'Trip not found'], 404);}
        $trip->delete();
        return response()->json([
        'message' => 'Trip deleted successfully',
        ], 201);
    }

    public function inventory()
    {
        $trips = QueryBuilder::for(Trip::class)
                ->allowedFilters(['location.destination', 'start_date'])
                ->with(['location:id,source', 'bookings'])
                ->get()
                ->map(function ($trip) {
                    $totalPriceSum = $trip->bookings->sum('total_price');
                    return [
                        'start_date' => $trip->start_date,
                        'total_price_sum' => $totalPriceSum,
                        'location' => [
                            'id' => $trip->location->id,
                            'source' => $trip->location->source,
                        ],
                    ];
                });
        return response()->json([
            "Trips" => $trips,
        ], 200);
        }
}
