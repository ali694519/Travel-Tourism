<?php

namespace App\Models;

use App\Models\Trip;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buses extends Model
{
    use HasFactory;
    protected $fillable = [
        'trip_id',
        'row_count',
        'left_row_count',
        'right_row_count',
        'last_row_count',
        'reserved_seats_count'
    ];
    public function trips()
    {
        return $this->belongsTo(Trip::class,'trip_id');
    }

    public function getTotalCountAttribute()
    {
        return $this->row_count + $this->left_row_count + $this->right_row_count + $this->last_row_count;
    }
}
