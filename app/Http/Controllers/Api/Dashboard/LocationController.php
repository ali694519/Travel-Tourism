<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Models\Location;
use App\Http\Controllers\Controller;
use App\Http\Requests\LocationRequest;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::with(['media', 'trips' => function ($query) {
        $query->where('status', 'available');
        }])->get();
        $formattedLocations = $locations->map(function ($location) {
            return $location->formatForJson();
        });

        return response()->json($formattedLocations);
    }

    public function store(LocationRequest $request)
    {
        $data = $request->except('images');
        $location = Location::create($data);
        foreach ($request->file('images') as $image) {
            $location->addMedia($image)->toMediaCollection('Locations');
        }
        return response()->json([
        'message' => 'Location created successfully',
        'Location' => $location], 201);
    }
    public function update(LocationRequest $request, string $id)
    {
        $location = Location::find($id);
        if (!$location) {return response()->json(['error' => 'Location not found'], 404);}
        $data = $request->except('images');
        $location->update($data);
        $location->clearMediaCollection('Locations');
        foreach ($request->file('images') as $image) {
            $location->addMedia($image)->toMediaCollection('Locations');
        }
        return response()->json([
            'message' => 'Location updated successfully',
            'location' => $location
        ], 200);
    }


    public function show($location)
    {
        $location = Location::find($location);
        if (!$location) {return response()->json(['error' => 'Location not found'], 404);}
        $location->load('categories:id,name','trips.buses','media');
        $location->media->transform(function ($media) {
            return [
                'media' => str_replace('http://localhost', '', $media->original_url)
            ];
        });
        return response()->json(['location' => $location], 200);
    }
    public function destroy($location)
    {
        $location = Location::find($location);
        if (!$location) {return response()->json(['error' => 'Location not found'], 404);}
        $location->delete();
        return response()->json([
        'message' => 'Location deleted successfully',
        ], 201);
    }
}
