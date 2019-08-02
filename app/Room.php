<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = [];

    public function hotel() {
      return $this->belongsTo('App\Hotel');
    }

    public function amenities() {
      return $this->belongsToMany('App\Amenity')->withTimestamps();
    }

    public function roomimgs() {
      return $this->hasMany('App\RoomImg');
    }

    public function roomreviews() {
      return $this->hasMany('App\RoomReview');
    }

    public function roombookings() {
      return $this->hasMany('App\RoomBooking');
    }
}
