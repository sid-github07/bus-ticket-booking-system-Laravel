<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lounge extends Model
{
    protected $guarded = [];

    public function amenities() {
      return $this->belongsToMany('App\Amenity')->withTimestamps();
    }

    public function loungeimgs() {
      return $this->hasMany('App\LoungeImg');
    }

    public function loungereviews() {
      return $this->hasMany('App\LoungeReview');
    }

    public function loungeclosingdays() {
      return $this->hasMany('App\LoungeClosingDay');
    }

    public function loungebookings() {
      return $this->hasMany('App\LoungeBooking');
    }    
}
