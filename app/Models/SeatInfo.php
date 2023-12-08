<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SeatInfo extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;
    protected $fillable = [
        'booking_id',
        'first_name',
        'last_name',
        'father_name',
        'mother_name',
        'place_of_birth',
        'date_of_place',
        'national_id',
        'card_image_front',
        'card_image_back',
        'seat_number'
    ];
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
