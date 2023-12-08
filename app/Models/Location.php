<?php

namespace App\Models;

use App\Models\Trip;
use App\Models\Image;
use App\Models\Category;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;
    protected $fillable = ['source','destination','category_id'];

    public function categories()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
    public function trips()
    {
        return $this->hasMany(Trip::class);
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
            'source' => $this->source,
            'destination' => $this->destination,
            'category_id' => $this->category_id,
            'media' => $this->formattedMedia,
            'trips' => $this->trips,
        ];
    }

}
