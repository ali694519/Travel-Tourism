<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Models\Buses;
use Illuminate\Http\Request;
use App\Http\Requests\BusesRequest;
use App\Http\Controllers\Controller;

class BusesController extends Controller
{
    public function index()
    {
        $bus = Buses::with("trips")->get();
        return response()->json($bus);
    }
    public function store(BusesRequest $request)
    {
        $data = $request->all();
        $bus = Buses::create($data);
        return response()->json([
        'message' => 'bus created successfully',
        'bus' => $bus], 201);
    }
    public function update(BusesRequest $request, string $id)
    {
        $bus = Buses::find($id);
        if (!$bus) {return response()->json(['error' => 'bus not found'], 404);}
        $data = $request->all();
        $bus->update($data);
         return response()->json([
        'message' => 'bus updated successfully',
        'bus' => $bus], 201);
    }
    public function show($bus)
    {
        $bus = Buses::find($bus);
        if (!$bus) {return response()->json(['error' => 'bus not found'], 404);}
        $bus->total_count = $bus->total_count;
        return response()->json(['bus' => $bus], 200);
    }
    public function destroy($bus)
    {
        $bus = Buses::find($bus);
        if (!$bus) {return response()->json(['error' => 'bus not found'], 404);}
        $bus->delete();
        return response()->json([
        'message' => 'bus deleted successfully',
        ], 201);
    }
}
