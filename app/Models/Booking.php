<?php

namespace App\Models;

use App\Models\Seat;
use App\Models\Trip;
use App\Models\User;
use App\Models\Booking;
use App\Models\SeatInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = ['trip_id','total_price','quantity'];

    public function trips()
    {
        return $this->belongsTo(Trip::class,"trip_id");
    }

    public function seats()
    {
        return $this->hasMany(SeatInfo::class);
    }

}
