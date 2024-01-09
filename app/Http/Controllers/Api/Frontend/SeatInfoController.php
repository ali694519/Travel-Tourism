<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Models\SeatInfo;
use App\Http\Controllers\Controller;

class SeatInfoController extends Controller
{
    public function index()
    {
        $user_details = SeatInfo::all();
        return response()->json($user_details);
    }
}
