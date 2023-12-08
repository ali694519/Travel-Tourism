<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Models\SeatInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserDetailsRequest;

class SeatInfoController extends Controller
{
    public function index()
    {
        $user_details = SeatInfo::all();
        return response()->json($user_details);
    }
}
