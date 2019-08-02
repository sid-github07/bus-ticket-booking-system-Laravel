<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $guarded = [];

    public function amenities() {
      return $this->belongsToMany('App\Amenity')->withTimestamps();
    }

    public function rooms() {
      return $this->hasMany('App\Room');
    }

    public function hotelimgs() {
      return $this->hasMany('App\HotelImg');
    }

    public function hotelreviews() {
      return $this->hasMany('App\HotelReview');
    }

}
