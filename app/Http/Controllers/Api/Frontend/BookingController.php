<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Models\Seat;
use App\Models\Trip;
use App\Models\Booking;
use App\Models\SeatInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('trips')
            ->get();
        return response()->json($bookings);
    }
    public function store(BookingRequest $request)
    {
        try {
            DB::beginTransaction();
            $price = Trip::findOrFail($request->trip_id)->price;
            $data = $request->all();
            $booking = Booking::create($data);
            $booking->total_price = $price * $request->quantity;
            $booking->save();
            if (isset($data['info']) && is_array($data['info'])) {
                foreach ($data['info'] as $info) {
                    SeatInfo::create([
                        'booking_id' => $booking->id,
                        'first_name' => $info['first_name'],
                        'last_name' => $info['last_name'],
                        'father_name' => $info['father_name'],
                        'mother_name' => $info['mother_name'],
                        'place_of_birth' => $info['place_of_birth'],
                        'date_of_place' => $info['date_of_place'],
                        'national_id' => $info['national_id'],
                        'seat_number' => $info['seat_number'],
                        'card_image_front' => Storage::disk('uploads')->put('user_images', $info['card_image_front']),
                        'card_image_back' => Storage::disk('uploads')->put('user_images', $info['card_image_back']),
                    ]);
                }
            }
            DB::commit();
            return response()->json([
                'message' => 'Booking created successfully',
                'Booking' => $booking
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'An error occurred while processing the request',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function show($booking)
    {
        $booking = Booking::find($booking);
        if (!$booking) {return response()->json(['error' => 'Booking not found'], 404);}
        $booking->load("trips","seats");
        return response()->json(['Booking' => $booking], 200);
    }
    public function destroy($booking)
    {
        $booking = Booking::find($booking);
        if (!$booking) {return response()->json(['error' => 'Booking not found'], 404);}
        return response()->json([
        'message' => 'Booking deleted successfully',
        ], 201);
    }
}
