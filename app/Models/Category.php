<?php

namespace App\Models;

use App\Models\Location;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;
    protected $fillable = ['name'];

    public function locations()
    {
        return $this->hasMany(Location::class);
    }
    public function getFormattedMediaAttribute()
     {
        return $this->media->map(function ($media) {
            return [
                'original_url' => str_replace('http://localhost', '', $media->original_url)
            ];
        });
    }
    public function formatForJson()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'locations' => $this->locations->map(function ($location) {
                return $location->formatForJson();
            }),
            'media' => $this->formattedMedia,
        ];
    }

}
