<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class notification extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;
    protected $fillable = [
        'trip_id',
        'title',
        'description',
    ];

    public function trips()
    {
        return $this->belongsTo(Trip::class,'trip_id');
    }

    public function getFormattedMediaAttribute()
    {
        return $this->media->map(function ($media) {
            return [
                'original_url' => str_replace('http://localhost', '', $media->original_url),
            ];
        });
    }
    public function formatForJson()
    {
        return [
            'id' => $this->id,
            'trip_id'=>$this->trip_id,
            'title' => $this->title,
            'description' => $this->description,
            'media' => $this->formattedMedia,
        ];
    }


}
