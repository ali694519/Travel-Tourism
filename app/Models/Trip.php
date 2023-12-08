<?php

namespace App\Models;

use App\Models\Buses;
use App\Models\Booking;
use App\Models\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trip extends Model
{
    use HasFactory;
    protected $fillable = ['start_date','duration','price','status','description','location_id'];


    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function buses()
    {
        return $this->hasOne(Buses::class);
    }

    // protected static function booted()
    // {
    //     static::addGlobalScope('available', function (Builder $builder) {
    //         $builder->where('status', 'available');
    //     });
    // }
}
